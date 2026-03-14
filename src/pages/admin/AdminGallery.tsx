import { useState } from "react";
import { Plus, Trash2, Edit2, X, Save, Upload, Image as ImageIcon } from "lucide-react";
import { getGalleryImages, addGalleryImage, deleteGalleryImage, updateGalleryImage, type GalleryImage } from "@/lib/store";

const AdminGallery = () => {
  const [images, setImages] = useState(getGalleryImages());
  const [showForm, setShowForm] = useState(false);
  const [editId, setEditId] = useState<string | null>(null);
  const [form, setForm] = useState({ src: "", alt: "", category: "events", title: "" });

  const MAX_IMAGES = 50;

  const refresh = () => setImages(getGalleryImages());

  const handleImageUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;

    if (!file.type.startsWith("image/")) {
      alert("Please upload an image file.");
      return;
    }

    const reader = new FileReader();
    reader.onload = (event) => {
      const img = new Image();
      img.onload = () => {
        const canvas = document.createElement("canvas");
        let width = img.width;
        let height = img.height;

        // Max dimensions
        const MAX_WIDTH = 800;
        const MAX_HEIGHT = 800;

        if (width > height) {
          if (width > MAX_WIDTH) {
            height *= MAX_WIDTH / width;
            width = MAX_WIDTH;
          }
        } else {
          if (height > MAX_HEIGHT) {
            width *= MAX_HEIGHT / height;
            height = MAX_HEIGHT;
          }
        }

        canvas.width = width;
        canvas.height = height;
        const ctx = canvas.getContext("2d");
        ctx?.drawImage(img, 0, 0, width, height);

        // Compress to JPEG format
        const dataUrl = canvas.toDataURL("image/jpeg", 0.7);
        setForm({ ...form, src: dataUrl });
      };
      img.src = event.target?.result as string;
    };
    reader.readAsDataURL(file);
  };

  const handleAdd = (e: React.FormEvent) => {
    e.preventDefault();
    if (images.length >= MAX_IMAGES) {
      alert(`Gallery limit reached. A maximum of ${MAX_IMAGES} images is allowed.`);
      return;
    }
    
    if (!form.src) {
      alert("Please upload an image.");
      return;
    }

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
        <div>
          <h1 className="font-display text-2xl font-bold text-foreground">Gallery Management</h1>
          <p className="text-sm text-muted-foreground mt-1">
            Gallery Usage: <span className={images.length >= MAX_IMAGES ? "text-destructive font-bold" : "text-foreground font-medium"}>{images.length}</span> / {MAX_IMAGES} images
          </p>
        </div>
        <button 
          onClick={() => { 
            if (images.length >= MAX_IMAGES) {
              alert(`Gallery limit reached. A maximum of ${MAX_IMAGES} images is allowed.`);
              return;
            }
            setShowForm(true); 
            setEditId(null); 
            setForm({ src: "", alt: "", category: "events", title: "" }); 
          }} 
          className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gold text-secondary-foreground text-sm font-semibold hover:bg-gold-dark transition-colors"
          disabled={images.length >= MAX_IMAGES}
        >
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
            <div className="sm:col-span-2">
              <label className="block text-sm font-medium text-foreground mb-1">Upload Image *</label>
              <div className="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-border border-dashed rounded-lg hover:border-gold transition-colors">
                <div className="space-y-1 text-center">
                  {form.src ? (
                    <div className="relative inline-block">
                      <img src={form.src} alt="Preview" className="mx-auto h-32 w-auto rounded-md object-cover" />
                      <button type="button" onClick={() => setForm({ ...form, src: "" })} className="absolute -top-2 -right-2 bg-destructive text-destructive-foreground rounded-full p-1 shadow-sm">
                        <X className="w-3 h-3" />
                      </button>
                    </div>
                  ) : (
                    <>
                      <ImageIcon className="mx-auto h-12 w-12 text-muted-foreground" />
                      <div className="flex text-sm text-muted-foreground justify-center">
                        <label htmlFor="file-upload" className="relative cursor-pointer rounded-md bg-background font-medium text-gold hover:text-gold-dark focus-within:outline-none">
                          <span>Upload a file</span>
                          <input id="file-upload" name="file-upload" type="file" className="sr-only" accept="image/*" onChange={handleImageUpload} />
                        </label>
                        <p className="pl-1">or drag and drop</p>
                      </div>
                      <p className="text-xs text-muted-foreground mt-2">PNG, JPG, GIF up to 5MB (Auto-compressed)</p>
                    </>
                  )}
                </div>
              </div>
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
