import { useState } from "react";
import { motion } from "framer-motion";
import { MapPin, Phone, Mail, Send, CheckCircle } from "lucide-react";
import SiteHeader from "@/components/SiteHeader";
import SiteFooter from "@/components/SiteFooter";
import HeroBanner from "@/components/HeroBanner";
import { contactInfo } from "@/data/schoolData";

const Contact = () => {
  const [formState, setFormState] = useState({ name: "", email: "", phone: "", message: "", subject: "General Enquiry" });
  const [submitted, setSubmitted] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    // In production, this would connect to an API endpoint
    setSubmitted(true);
    setTimeout(() => setSubmitted(false), 5000);
    setFormState({ name: "", email: "", phone: "", message: "", subject: "General Enquiry" });
  };

  const contactCards = [
    { icon: <MapPin className="w-6 h-6" />, title: "Visit Us", content: contactInfo.address },
    { icon: <Phone className="w-6 h-6" />, title: "Call Us", content: `Office: ${contactInfo.phones.office}\nPrincipal: ${contactInfo.phones.principal}\nAdmin: ${contactInfo.phones.admin}` },
    { icon: <Mail className="w-6 h-6" />, title: "Email Us", content: contactInfo.email },
  ];

  return (
    <>
      <SiteHeader />
      <HeroBanner title="Contact Us" breadcrumb="Contact" />
      <main>
        {/* Contact Cards */}
        <section className="section-padding bg-background">
          <div className="container mx-auto">
            <div className="grid md:grid-cols-3 gap-6 mb-16">
              {contactCards.map((card, i) => (
                <motion.div
                  key={card.title}
                  initial={{ opacity: 0, y: 30 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  viewport={{ once: true }}
                  transition={{ delay: i * 0.1 }}
                  className="bg-card rounded-xl p-8 card-hover border border-border text-center"
                >
                  <div className="w-14 h-14 rounded-full bg-gold/10 text-gold flex items-center justify-center mx-auto mb-4">
                    {card.icon}
                  </div>
                  <h3 className="font-display text-lg font-semibold text-foreground mb-2">{card.title}</h3>
                  <p className="text-muted-foreground text-sm whitespace-pre-line">{card.content}</p>
                </motion.div>
              ))}
            </div>

            {/* Form + Map */}
            <div className="grid lg:grid-cols-2 gap-10">
              <motion.div initial={{ opacity: 0, x: -30 }} whileInView={{ opacity: 1, x: 0 }} viewport={{ once: true }}>
                <h2 className="section-title mb-2">Send an Enquiry</h2>
                <p className="text-muted-foreground mb-8">Fill in the form below and we'll get back to you shortly.</p>

                {submitted && (
                  <div className="flex items-center gap-3 bg-gold/10 text-gold rounded-lg p-4 mb-6">
                    <CheckCircle className="w-5 h-5" />
                    <span className="font-medium text-sm">Thank you! Your enquiry has been submitted successfully.</span>
                  </div>
                )}

                <form onSubmit={handleSubmit} className="space-y-5">
                  <div className="grid sm:grid-cols-2 gap-5">
                    <div>
                      <label htmlFor="name" className="block text-sm font-medium text-foreground mb-1.5">Full Name *</label>
                      <input
                        id="name"
                        type="text"
                        required
                        maxLength={100}
                        value={formState.name}
                        onChange={(e) => setFormState({ ...formState, name: e.target.value })}
                        className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                        placeholder="Your full name"
                      />
                    </div>
                    <div>
                      <label htmlFor="email" className="block text-sm font-medium text-foreground mb-1.5">Email *</label>
                      <input
                        id="email"
                        type="email"
                        required
                        maxLength={255}
                        value={formState.email}
                        onChange={(e) => setFormState({ ...formState, email: e.target.value })}
                        className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                        placeholder="your@email.com"
                      />
                    </div>
                  </div>
                  <div className="grid sm:grid-cols-2 gap-5">
                    <div>
                      <label htmlFor="phone" className="block text-sm font-medium text-foreground mb-1.5">Phone</label>
                      <input
                        id="phone"
                        type="tel"
                        maxLength={15}
                        value={formState.phone}
                        onChange={(e) => setFormState({ ...formState, phone: e.target.value })}
                        className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                        placeholder="+91-XXXXXXXXXX"
                      />
                    </div>
                    <div>
                      <label htmlFor="subject" className="block text-sm font-medium text-foreground mb-1.5">Subject</label>
                      <select
                        id="subject"
                        value={formState.subject}
                        onChange={(e) => setFormState({ ...formState, subject: e.target.value })}
                        className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                      >
                        <option>General Enquiry</option>
                        <option>Admissions</option>
                        <option>Transport</option>
                        <option>Fee Structure</option>
                        <option>Other</option>
                      </select>
                    </div>
                  </div>
                  <div>
                    <label htmlFor="message" className="block text-sm font-medium text-foreground mb-1.5">Message *</label>
                    <textarea
                      id="message"
                      required
                      maxLength={1000}
                      rows={5}
                      value={formState.message}
                      onChange={(e) => setFormState({ ...formState, message: e.target.value })}
                      className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring resize-none"
                      placeholder="How can we help you?"
                    />
                  </div>
                  <button
                    type="submit"
                    className="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors"
                  >
                    <Send className="w-4 h-4" /> Submit Enquiry
                  </button>
                </form>
              </motion.div>

              <motion.div initial={{ opacity: 0, x: 30 }} whileInView={{ opacity: 1, x: 0 }} viewport={{ once: true }}>
                <div className="rounded-2xl overflow-hidden h-full min-h-[400px] border border-border">
                  <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3880.0!2d76.38!3d12.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sNagashree+English+School+Channarayapatna!5e0!3m2!1sen!2sin!4v1"
                    width="100%"
                    height="100%"
                    style={{ border: 0, minHeight: 400 }}
                    allowFullScreen
                    loading="lazy"
                    referrerPolicy="no-referrer-when-downgrade"
                    title="Nagashree English School location on Google Maps"
                  />
                </div>
              </motion.div>
            </div>
          </div>
        </section>
      </main>
      <SiteFooter />
    </>
  );
};

export default Contact;
