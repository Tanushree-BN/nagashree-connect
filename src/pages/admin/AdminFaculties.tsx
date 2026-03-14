import { useState } from "react";
import { Plus, Trash2, Edit2, X, Save, User, Image as ImageIcon } from "lucide-react";
import { getFaculties, addFaculty, deleteFaculty, updateFaculty, type FacultyMember } from "@/lib/store";

const AdminFaculties = () => {
  const [list, setList] = useState(getFaculties());
  const [showForm, setShowForm] = useState(false);
  const [editId, setEditId] = useState<string | null>(null);
  const [form, setForm] = useState({ name: "", role: "", subject: "", experience: "", image: "" });

  const refresh = () => setList(getFaculties());

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

        // Max dimensions for Avatar
        const MAX_WIDTH = 400;
        const MAX_HEIGHT = 400;

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
        setForm({ ...form, image: dataUrl });
      };
      img.src = event.target?.result as string;
    };
    reader.readAsDataURL(file);
  };

  const handleAdd = (e: React.FormEvent) => {
    e.preventDefault();
    addFaculty(form);
    setForm({ name: "", role: "", subject: "", experience: "", image: "" });
    setShowForm(false);
    refresh();
  };

  const handleUpdate = (e: React.FormEvent) => {
    e.preventDefault();
    if (editId) {
      updateFaculty(editId, form);
      setEditId(null);
      setForm({ name: "", role: "", subject: "", experience: "", image: "" });
      refresh();
    }
  };

  const handleDelete = (id: string) => {
    if (confirm("Delete this faculty member?")) {
      deleteFaculty(id);
      refresh();
    }
  };

  const startEdit = (f: FacultyMember) => {
    setEditId(f.id);
    setForm({ name: f.name, role: f.role, subject: f.subject, experience: f.experience, image: f.image || "" });
    setShowForm(false);
  };

  return (
    <div>
      <div className="flex items-center justify-between mb-6">
        <h1 className="font-display text-2xl font-bold text-foreground">Faculty Management</h1>
        <button onClick={() => { setShowForm(true); setEditId(null); setForm({ name: "", role: "", subject: "", experience: "", image: "" }); }} className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gold text-secondary-foreground text-sm font-semibold hover:bg-gold-dark transition-colors">
          <Plus className="w-4 h-4" /> Add Faculty
        </button>
      </div>

      {(showForm || editId) && (
        <form onSubmit={editId ? handleUpdate : handleAdd} className="bg-card rounded-xl p-6 border border-border mb-6 space-y-4">
          <div className="flex items-center justify-between">
            <h3 className="font-semibold text-foreground">{editId ? "Edit Faculty" : "Add New Faculty"}</h3>
            <button type="button" onClick={() => { setShowForm(false); setEditId(null); }} className="text-muted-foreground hover:text-foreground"><X className="w-4 h-4" /></button>
          </div>
          <div className="grid sm:grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-medium text-foreground mb-1">Name *</label>
              <input required value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} className="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" />
            </div>
            <div>
              <label className="block text-sm font-medium text-foreground mb-1">Role *</label>
              <input required value={form.role} onChange={(e) => setForm({ ...form, role: e.target.value })} className="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" />
            </div>
            <div>
              <label className="block text-sm font-medium text-foreground mb-1">Subject *</label>
              <input required value={form.subject} onChange={(e) => setForm({ ...form, subject: e.target.value })} className="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" />
            </div>
            <div>
              <label className="block text-sm font-medium text-foreground mb-1">Experience *</label>
              <input required value={form.experience} onChange={(e) => setForm({ ...form, experience: e.target.value })} className="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="e.g. 10 years" />
            </div>
            <div className="sm:col-span-2">
              <label className="block text-sm font-medium text-foreground mb-1">Profile Picture (Optional)</label>
              <div className="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-border border-dashed rounded-lg hover:border-gold transition-colors">
                <div className="space-y-1 text-center">
                  {form.image ? (
                    <div className="relative inline-block">
                      <img src={form.image} alt="Preview" className="mx-auto h-24 w-24 rounded-full object-cover shadow-md" />
                      <button type="button" onClick={() => setForm({ ...form, image: "" })} className="absolute -top-1 -right-1 bg-destructive text-destructive-foreground rounded-full p-1 shadow-sm">
                        <X className="w-3 h-3" />
                      </button>
                    </div>
                  ) : (
                    <>
                      <User className="mx-auto h-12 w-12 text-muted-foreground" />
                      <div className="flex text-sm text-muted-foreground justify-center">
                        <label className="relative cursor-pointer rounded-md bg-background font-medium text-gold hover:text-gold-dark focus-within:outline-none">
                          <span>Upload a photo</span>
                          <input type="file" className="sr-only" accept="image/*" onChange={handleImageUpload} />
                        </label>
                      </div>
                      <p className="text-xs text-muted-foreground mt-2">Will be cropped and compressed</p>
                    </>
                  )}
                </div>
              </div>
            </div>
          </div>
          <button type="submit" className="inline-flex items-center gap-2 px-6 py-2 rounded-lg bg-gold text-secondary-foreground text-sm font-semibold hover:bg-gold-dark transition-colors">
            <Save className="w-4 h-4" /> {editId ? "Update" : "Add"}
          </button>
        </form>
      )}

      <div className="bg-card rounded-xl border border-border overflow-hidden">
        <table className="w-full text-sm">
          <thead className="bg-muted">
            <tr>
              <th className="text-left px-4 py-3 text-muted-foreground font-medium">Pic</th>
              <th className="text-left px-4 py-3 text-muted-foreground font-medium">Name</th>
              <th className="text-left px-4 py-3 text-muted-foreground font-medium">Role</th>
              <th className="text-left px-4 py-3 text-muted-foreground font-medium">Subject</th>
              <th className="text-left px-4 py-3 text-muted-foreground font-medium">Experience</th>
              <th className="text-right px-4 py-3 text-muted-foreground font-medium">Actions</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-border">
            {list.map((f) => (
              <tr key={f.id} className="hover:bg-muted/50">
                <td className="px-4 py-3">
                  {f.image ? (
                    <img src={f.image} alt={f.name} className="w-10 h-10 rounded-full object-cover bg-muted" />
                  ) : (
                    <div className="w-10 h-10 rounded-full bg-muted flex items-center justify-center">
                      <User className="w-5 h-5 text-muted-foreground" />
                    </div>
                  )}
                </td>
                <td className="px-4 py-3 text-foreground font-medium">{f.name}</td>
                <td className="px-4 py-3 text-gold">{f.role}</td>
                <td className="px-4 py-3 text-muted-foreground">{f.subject}</td>
                <td className="px-4 py-3 text-muted-foreground">{f.experience}</td>
                <td className="px-4 py-3 text-right">
                  <button onClick={() => startEdit(f)} className="p-1.5 rounded text-muted-foreground hover:text-gold"><Edit2 className="w-4 h-4" /></button>
                  <button onClick={() => handleDelete(f.id)} className="p-1.5 rounded text-muted-foreground hover:text-destructive ml-1"><Trash2 className="w-4 h-4" /></button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
        {list.length === 0 && <p className="text-center py-8 text-muted-foreground">No faculty members yet.</p>}
      </div>
    </div>
  );
};

export default AdminFaculties;
