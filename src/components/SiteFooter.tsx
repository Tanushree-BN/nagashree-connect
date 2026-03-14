import { Link } from "react-router-dom";
import { MapPin, Phone, Mail, Youtube, Facebook, Instagram } from "lucide-react";
import { contactInfo } from "@/data/schoolData";

const SiteFooter = () => {
  return (
    <footer className="gradient-navy text-primary-foreground">
      <div className="container mx-auto px-4 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
          {/* About */}
          <div>
            <h3 className="font-display text-xl font-bold mb-4 text-gold">{contactInfo.schoolName}</h3>
            <p className="text-primary-foreground/70 text-sm leading-relaxed">
              Empowering young minds with quality education, strong values, and holistic development. Your child's bright future starts here.
            </p>
            <div className="flex gap-3 mt-6">
              <a href={contactInfo.socialLinks.facebook} target="_blank" rel="noopener noreferrer" className="w-9 h-9 rounded-full bg-primary-foreground/10 flex items-center justify-center hover:bg-gold hover:text-secondary-foreground transition-colors" aria-label="Facebook">
                <Facebook className="w-4 h-4" />
              </a>
              <a href={contactInfo.socialLinks.instagram} target="_blank" rel="noopener noreferrer" className="w-9 h-9 rounded-full bg-primary-foreground/10 flex items-center justify-center hover:bg-gold hover:text-secondary-foreground transition-colors" aria-label="Instagram">
                <Instagram className="w-4 h-4" />
              </a>
              <a href={contactInfo.socialLinks.youtube} target="_blank" rel="noopener noreferrer" className="w-9 h-9 rounded-full bg-primary-foreground/10 flex items-center justify-center hover:bg-gold hover:text-secondary-foreground transition-colors" aria-label="YouTube">
                <Youtube className="w-4 h-4" />
              </a>
            </div>
          </div>

          {/* Quick Links */}
          <div>
            <h4 className="font-display text-lg font-semibold mb-4">Quick Links</h4>
            <ul className="space-y-2.5">
              {[
                { label: "Home", path: "/" },
                { label: "About Us", path: "/about" },
                { label: "Admission", path: "/admission" },
                { label: "Gallery", path: "/gallery" },
                { label: "Our Faculty", path: "/faculties" },
                { label: "Facilities", path: "/facilities" },
                { label: "Contact", path: "/contact" },
              ].map((link) => (
                <li key={link.path}>
                  <Link to={link.path} className="text-primary-foreground/70 hover:text-gold transition-colors text-sm">{link.label}</Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact */}
          <div>
            <h4 className="font-display text-lg font-semibold mb-4">Contact Us</h4>
            <div className="space-y-4 text-sm">
              <div className="flex gap-3">
                <MapPin className="w-4 h-4 text-gold shrink-0 mt-1" />
                <span className="text-primary-foreground/70">{contactInfo.address}</span>
              </div>
              <div className="flex gap-3">
                <Phone className="w-4 h-4 text-gold shrink-0 mt-0.5" />
                <div className="text-primary-foreground/70">
                  <p>Office: <a href={`tel:${contactInfo.phones.office}`} className="hover:text-gold transition-colors">{contactInfo.phones.office}</a></p>
                  <p>Principal: <a href={`tel:${contactInfo.phones.principal}`} className="hover:text-gold transition-colors">{contactInfo.phones.principal}</a></p>
                </div>
              </div>
              <div className="flex gap-3">
                <Mail className="w-4 h-4 text-gold shrink-0 mt-0.5" />
                <a href={`mailto:${contactInfo.email}`} className="text-primary-foreground/70 hover:text-gold transition-colors">{contactInfo.email}</a>
              </div>
            </div>
          </div>

          {/* Connect */}
          <div>
            <h4 className="font-display text-lg font-semibold mb-4">Connect With Us</h4>
            <ul className="space-y-2.5 text-sm">
              <li><a href={contactInfo.socialLinks.youtube} target="_blank" rel="noopener noreferrer" className="text-primary-foreground/70 hover:text-gold transition-colors">YouTube</a></li>
              <li><a href={contactInfo.socialLinks.facebook} target="_blank" rel="noopener noreferrer" className="text-primary-foreground/70 hover:text-gold transition-colors">Facebook</a></li>
              <li><a href={contactInfo.socialLinks.instagram} target="_blank" rel="noopener noreferrer" className="text-primary-foreground/70 hover:text-gold transition-colors">Instagram</a></li>
            </ul>
          </div>
        </div>

        <div className="border-t border-primary-foreground/10 mt-12 pt-8 text-center text-primary-foreground/50 text-sm">
          <p>© {new Date().getFullYear()} {contactInfo.schoolName}. All rights reserved.</p>
          <p className="mt-2">
            Designed by{" "}
            <a href="https://mitrasoftwares.in/" target="_blank" rel="noopener noreferrer" className="text-gold hover:text-gold-light transition-colors">
              Mitra Softwares
            </a>
          </p>
        </div>
      </div>
    </footer>
  );
};

export default SiteFooter;
