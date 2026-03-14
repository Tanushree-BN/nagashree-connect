import { useState } from "react";
import { Plus, Trash2, Edit2, X, Save } from "lucide-react";
import { getGalleryImages, addGalleryImage, deleteGalleryImage, updateGalleryImage, type GalleryImage } from "@/lib/store";

const AdminGallery = () => {
  const [images, setImages] = useState(getGalleryImages());
  const [showForm, setShowForm] = useState(false);
  const [editId, setEditId] = useState<string | null>(null);
  const [form, setForm] = useState({ src: "", alt: "", category: "events", title: "" });

  const refresh = () => setImages(getGalleryImages());

  const handleAdd = (e: React.FormEvent) => {
    e.preventDefault();
    addGalleryImage(form);
    setForm({ src: "", alt: "", category: "events", title: "" });
    setShowForm(false);
    refresh();
  };

  const handleUpdate = (e: React.FormEvent) => {
    e.preventDefault();
    if (editId) {
      updateGalleryImage(editId, form);
      setEditId(null);
      setForm({ src: "", alt: "", category: "events", title: "" });
      refresh();
    }
  };

  const handleDelete = (id: string) => {
    if (confirm("Delete this image?")) {
      deleteGalleryImage(id);
      refresh();
    }
  };

  const startEdit = (img: GalleryImage) => {
    setEditId(img.id);
    setForm({ src: img.src, alt: img.alt, category: img.category, title: img.title });
    setShowForm(false);
  };

  return (
    <div>
      <div className="flex items-center justify-between mb-6">
        <h1 className="font-display text-2xl font-bold text-foreground">Gallery Management</h1>
        <button onClick={() => { setShowForm(true); setEditId(null); setForm({ src: "", alt: "", category: "events", title: "" }); }} className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gold text-secondary-foreground text-sm font-semibold hover:bg-gold-dark transition-colors">
          <Plus className="w-4 h-4" /> Add Image
        </button>
      </div>

      {/* Add/Edit Form */}
      {(showForm || editId) && (
        <form onSubmit={editId ? handleUpdate : handleAdd} className="bg-card rounded-xl p-6 border border-border mb-6 space-y-4">
          <div className="flex items-center justify-between">
            <h3 className="font-semibold text-foreground">{editId ? "Edit Image" : "Add New Image"}</h3>
            <button type="button" onClick={() => { setShowForm(false); setEditId(null); }} className="text-muted-foreground hover:text-foreground"><X className="w-4 h-4" /></button>
          </div>
          <div className="grid sm:grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-medium text-foreground mb-1">Image URL *</label>
              <input required value={form.src} onChange={(e) => setForm({ ...form, src: e.target.value })} className="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="https://... or /placeholder.svg" />
            </div>
            <div>
              <label className="block text-sm font-medium text-foreground mb-1">Title *</label>
              <input required value={form.title} onChange={(e) => setForm({ ...form, title: e.target.value })} className="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Image title" />
            </div>
            <div>
              <label className="block text-sm font-medium text-foreground mb-1">Alt Text *</label>
              <input required value={form.alt} onChange={(e) => setForm({ ...form, alt: e.target.value })} className="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Descriptive alt text" />
            </div>
            <div>
              <label className="block text-sm font-medium text-foreground mb-1">Category *</label>
              <select value={form.category} onChange={(e) => setForm({ ...form, category: e.target.value })} className="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                <option value="events">Events</option>
                <option value="classroom">Classroom</option>
                <option value="sports">Sports</option>
                <option value="facilities">Facilities</option>
              </select>
            </div>
          </div>
          <button type="submit" className="inline-flex items-center gap-2 px-6 py-2 rounded-lg bg-gold text-secondary-foreground text-sm font-semibold hover:bg-gold-dark transition-colors">
            <Save className="w-4 h-4" /> {editId ? "Update" : "Add"}
          </button>
        </form>
      )}

      {/* Table */}
      <div className="bg-card rounded-xl border border-border overflow-hidden">
        <table className="w-full text-sm">
          <thead className="bg-muted">
            <tr>
              <th className="text-left px-4 py-3 text-muted-foreground font-medium">Preview</th>
              <th className="text-left px-4 py-3 text-muted-foreground font-medium">Title</th>
              <th className="text-left px-4 py-3 text-muted-foreground font-medium">Category</th>
              <th className="text-right px-4 py-3 text-muted-foreground font-medium">Actions</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-border">
            {images.map((img) => (
              <tr key={img.id} className="hover:bg-muted/50">
                <td className="px-4 py-3"><img src={img.src} alt={img.alt} className="w-12 h-12 rounded object-cover bg-muted" /></td>
                <td className="px-4 py-3 text-foreground">{img.title}</td>
                <td className="px-4 py-3 capitalize text-muted-foreground">{img.category}</td>
                <td className="px-4 py-3 text-right">
                  <button onClick={() => startEdit(img)} className="p-1.5 rounded text-muted-foreground hover:text-gold"><Edit2 className="w-4 h-4" /></button>
                  <button onClick={() => handleDelete(img.id)} className="p-1.5 rounded text-muted-foreground hover:text-destructive ml-1"><Trash2 className="w-4 h-4" /></button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
        {images.length === 0 && <p className="text-center py-8 text-muted-foreground">No images yet.</p>}
      </div>
    </div>
  );
};

export default AdminGallery;
