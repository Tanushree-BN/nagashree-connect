import { useState } from "react";
import { Eye, Trash2, FileText, Download, CheckCircle, Clock } from "lucide-react";
import { getAdmissions, markAdmissionSeen, deleteAdmission, type AdmissionForm } from "@/lib/store";
import jsPDF from "jspdf";

const AdminAdmissions = () => {
  const [admissions, setAdmissions] = useState(getAdmissions());
  const [viewId, setViewId] = useState<string | null>(null);

  const refresh = () => setAdmissions(getAdmissions());

  const handleView = (id: string) => {
    markAdmissionSeen(id);
    setViewId(viewId === id ? null : id);
    refresh();
  };

  const handleDelete = (id: string) => {
    if (confirm("Delete this admission form?")) {
      deleteAdmission(id);
      setViewId(null);
      refresh();
    }
  };

  const downloadPDF = (form: AdmissionForm) => {
    const doc = new jsPDF();
    doc.setFontSize(18);
    doc.text("Nagashree English School - Admission Form", 20, 20);
    doc.setFontSize(11);
    const fields = [
      ["Student Name", form.studentName],
      ["Parent/Guardian", form.parentName],
      ["Date of Birth", form.dob],
      ["Gender", form.gender],
      ["Class Applied", form.classApplying],
      ["Phone", form.phone],
      ["Email", form.email || "N/A"],
      ["Address", form.address],
      ["Previous School", form.previousSchool || "N/A"],
      ["Previous Grade", form.previousGrade || "N/A"],
      ["Aadhaar", form.aadhaar || "N/A"],
      ["Submitted On", new Date(form.date).toLocaleString()],
    ];
    let y = 35;
    fields.forEach(([label, value]) => {
      doc.setFont("helvetica", "bold");
      doc.text(`${label}:`, 20, y);
      doc.setFont("helvetica", "normal");
      doc.text(String(value), 75, y);
      y += 8;
    });
    doc.save(`admission_${form.studentName.replace(/\s+/g, "_")}.pdf`);
  };

  const unseen = admissions.filter((a) => !a.seen).length;

  return (
    <div>
      <div className="flex items-center justify-between mb-6">
        <div>
          <h1 className="font-display text-2xl font-bold text-foreground">Admission Forms</h1>
          {unseen > 0 && <p className="text-gold text-sm mt-1">{unseen} new submission{unseen > 1 ? "s" : ""}</p>}
        </div>
      </div>

      {admissions.length === 0 ? (
        <div className="bg-card rounded-xl border border-border p-12 text-center">
          <FileText className="w-12 h-12 text-muted-foreground mx-auto mb-3" />
          <p className="text-muted-foreground">No admission forms submitted yet.</p>
        </div>
      ) : (
        <div className="space-y-3">
          {admissions.map((form) => (
            <div key={form.id} className={`bg-card rounded-xl border ${form.seen ? "border-border" : "border-gold"} overflow-hidden`}>
              <div className="flex items-center justify-between px-5 py-4 cursor-pointer hover:bg-muted/50" onClick={() => handleView(form.id)}>
                <div className="flex items-center gap-3">
                  {form.seen ? <CheckCircle className="w-4 h-4 text-muted-foreground" /> : <Clock className="w-4 h-4 text-gold" />}
                  <div>
                    <span className={`font-medium text-sm ${form.seen ? "text-foreground" : "text-foreground font-semibold"}`}>{form.studentName}</span>
                    <span className="text-muted-foreground text-xs ml-3">Class: {form.classApplying}</span>
                    {!form.seen && <span className="ml-2 px-2 py-0.5 rounded-full bg-gold/10 text-gold text-xs font-medium">New</span>}
                  </div>
                </div>
                <div className="flex items-center gap-2">
                  <span className="text-muted-foreground text-xs">{new Date(form.date).toLocaleDateString()}</span>
                  <button onClick={(e) => { e.stopPropagation(); downloadPDF(form); }} className="p-1 text-muted-foreground hover:text-gold" title="Download PDF"><Download className="w-4 h-4" /></button>
                  <button onClick={(e) => { e.stopPropagation(); handleDelete(form.id); }} className="p-1 text-muted-foreground hover:text-destructive"><Trash2 className="w-4 h-4" /></button>
                </div>
              </div>
              {viewId === form.id && (
                <div className="px-5 pb-5 border-t border-border pt-4 text-sm">
                  <div className="grid sm:grid-cols-2 gap-3">
                    {[
                      ["Student Name", form.studentName],
                      ["Parent/Guardian", form.parentName],
                      ["Date of Birth", form.dob],
                      ["Gender", form.gender],
                      ["Class Applied", form.classApplying],
                      ["Phone", form.phone],
                      ["Email", form.email || "N/A"],
                      ["Previous School", form.previousSchool || "N/A"],
                      ["Previous Grade", form.previousGrade || "N/A"],
                      ["Aadhaar", form.aadhaar || "N/A"],
                    ].map(([label, value]) => (
                      <div key={label}>
                        <span className="text-muted-foreground">{label}:</span>{" "}
                        <span className="text-foreground font-medium">{value}</span>
                      </div>
                    ))}
                  </div>
                  <div className="mt-3">
                    <span className="text-muted-foreground">Address:</span>{" "}
                    <span className="text-foreground">{form.address}</span>
                  </div>
                </div>
              )}
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default AdminAdmissions;
