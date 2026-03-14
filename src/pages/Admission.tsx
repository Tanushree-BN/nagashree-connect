import { useState } from "react";
import { motion } from "framer-motion";
import { GraduationCap, CheckCircle, ArrowRight } from "lucide-react";
import SiteHeader from "@/components/SiteHeader";
import SiteFooter from "@/components/SiteFooter";
import HeroBanner from "@/components/HeroBanner";
import { schoolDescription } from "@/data/schoolData";
import { addAdmission } from "@/lib/store";

const initialForm = {
  studentName: "",
  parentName: "",
  dob: "",
  gender: "",
  classApplying: "",
  phone: "",
  email: "",
  address: "",
  previousSchool: "",
  previousGrade: "",
  aadhaar: "",
};

const Admission = () => {
  const [form, setForm] = useState(initialForm);
  const [submitted, setSubmitted] = useState(false);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    addAdmission(form);
    setSubmitted(true);
    setForm(initialForm);
    setTimeout(() => setSubmitted(false), 6000);
  };

  return (
    <>
      <SiteHeader />
      <HeroBanner title="Admission" breadcrumb="Admission" />
      <main>
        {/* About School */}
        <section className="section-padding bg-background">
          <div className="container mx-auto max-w-4xl text-center">
            <GraduationCap className="w-12 h-12 text-gold mx-auto mb-4" />
            <h2 className="section-title mb-6">About Nagashree English School</h2>
            <p className="text-muted-foreground leading-relaxed">{schoolDescription}</p>
          </div>
        </section>

        {/* Admissions Banner */}
        <section className="gradient-navy py-12">
          <div className="container mx-auto text-center">
            <motion.div initial={{ opacity: 0, scale: 0.95 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }}>
              <span className="text-gold font-semibold text-sm uppercase tracking-widest">Now Enrolling</span>
              <h2 className="font-display text-3xl md:text-5xl font-bold text-primary-foreground mt-4 mb-4">
                Admissions Open for 2025-26
              </h2>
              <p className="text-primary-foreground/70 text-lg max-w-xl mx-auto">
                Give your child the gift of quality education. Limited seats available — apply now!
              </p>
            </motion.div>
          </div>
        </section>

        {/* Admission Form */}
        <section className="section-padding bg-muted">
          <div className="container mx-auto max-w-3xl">
            <div className="text-center mb-10">
              <h2 className="section-title mb-2">Online Admission Form</h2>
              <p className="text-muted-foreground">Fill in the details below to apply for admission.</p>
            </div>

            {submitted && (
              <div className="flex items-center gap-3 bg-gold/10 text-gold rounded-lg p-4 mb-6">
                <CheckCircle className="w-5 h-5" />
                <span className="font-medium text-sm">Your admission form has been submitted successfully! We will contact you shortly.</span>
              </div>
            )}

            <form onSubmit={handleSubmit} className="bg-card rounded-xl p-8 border border-border space-y-5">
              <div className="grid sm:grid-cols-2 gap-5">
                <div>
                  <label className="block text-sm font-medium text-foreground mb-1.5">Student Full Name *</label>
                  <input name="studentName" required maxLength={100} value={form.studentName} onChange={handleChange} className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Student's full name" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-foreground mb-1.5">Parent/Guardian Name *</label>
                  <input name="parentName" required maxLength={100} value={form.parentName} onChange={handleChange} className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Parent/Guardian name" />
                </div>
              </div>

              <div className="grid sm:grid-cols-3 gap-5">
                <div>
                  <label className="block text-sm font-medium text-foreground mb-1.5">Date of Birth *</label>
                  <input name="dob" type="date" required value={form.dob} onChange={handleChange} className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-foreground mb-1.5">Gender *</label>
                  <select name="gender" required value={form.gender} onChange={handleChange} className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div>
                  <label className="block text-sm font-medium text-foreground mb-1.5">Class Applying For *</label>
                  <select name="classApplying" required value={form.classApplying} onChange={handleChange} className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                    <option value="">Select Class</option>
                    <option>Nursery</option>
                    <option>LKG</option>
                    <option>UKG</option>
                    {Array.from({ length: 10 }, (_, i) => <option key={i + 1}>Class {i + 1}</option>)}
                  </select>
                </div>
              </div>

              <div className="grid sm:grid-cols-2 gap-5">
                <div>
                  <label className="block text-sm font-medium text-foreground mb-1.5">Phone Number *</label>
                  <input name="phone" type="tel" required maxLength={15} value={form.phone} onChange={handleChange} className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="+91-XXXXXXXXXX" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-foreground mb-1.5">Email</label>
                  <input name="email" type="email" maxLength={255} value={form.email} onChange={handleChange} className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="parent@email.com" />
                </div>
              </div>

              <div>
                <label className="block text-sm font-medium text-foreground mb-1.5">Address *</label>
                <textarea name="address" required maxLength={500} rows={3} value={form.address} onChange={handleChange} className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring resize-none" placeholder="Full residential address" />
              </div>

              <div className="grid sm:grid-cols-3 gap-5">
                <div>
                  <label className="block text-sm font-medium text-foreground mb-1.5">Previous School</label>
                  <input name="previousSchool" maxLength={200} value={form.previousSchool} onChange={handleChange} className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Previous school name" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-foreground mb-1.5">Previous Grade/Marks</label>
                  <input name="previousGrade" maxLength={50} value={form.previousGrade} onChange={handleChange} className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="e.g. A Grade / 85%" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-foreground mb-1.5">Aadhaar Number</label>
                  <input name="aadhaar" maxLength={14} value={form.aadhaar} onChange={handleChange} className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="XXXX-XXXX-XXXX" />
                </div>
              </div>

              <button type="submit" className="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors w-full justify-center">
                Submit Application <ArrowRight className="w-4 h-4" />
              </button>
            </form>
          </div>
        </section>
      </main>
      <SiteFooter />
    </>
  );
};

export default Admission;
