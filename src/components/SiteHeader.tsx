import { useState, useEffect } from "react";
import { Link, useLocation } from "react-router-dom";
import { Menu, X, Phone, Mail } from "lucide-react";
import { contactInfo } from "@/data/schoolData";
import logo from "@/assets/logo.png";

const navLinks = [
  { label: "Home", path: "/" },
  { label: "About", path: "/about" },
  { label: "Admission", path: "/admission" },
  { label: "Gallery", path: "/gallery" },
  { label: "Faculties", path: "/faculties" },
  { label: "Facilities", path: "/facilities" },
  { label: "Contact", path: "/contact" },
];

const SiteHeader = () => {
  const [mobileOpen, setMobileOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const location = useLocation();

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 20);
    window.addEventListener("scroll", onScroll);
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  useEffect(() => {
    setMobileOpen(false);
  }, [location.pathname]);

  return (
    <>
      {/* Utility bar */}
      <div className="gradient-navy text-primary-foreground text-sm py-2 px-4 hidden md:block">
        <div className="container mx-auto flex justify-between items-center">
          <div className="flex items-center gap-6">
            <a href={`mailto:${contactInfo.email}`} className="flex items-center gap-1.5 hover:text-gold transition-colors">
              <Mail className="w-3.5 h-3.5" />
              {contactInfo.email}
            </a>
            <a href={`tel:${contactInfo.phones.office}`} className="flex items-center gap-1.5 hover:text-gold transition-colors">
              <Phone className="w-3.5 h-3.5" />
              {contactInfo.phones.office}
            </a>
          </div>
          <div className="flex items-center gap-4">
            <a href={contactInfo.socialLinks.facebook} target="_blank" rel="noopener noreferrer" className="hover:text-gold transition-colors" aria-label="Facebook">Facebook</a>
            <a href={contactInfo.socialLinks.instagram} target="_blank" rel="noopener noreferrer" className="hover:text-gold transition-colors" aria-label="Instagram">Instagram</a>
            <a href={contactInfo.socialLinks.youtube} target="_blank" rel="noopener noreferrer" className="hover:text-gold transition-colors" aria-label="YouTube">YouTube</a>
          </div>
        </div>
      </div>

      {/* Main nav */}
      <header className={`sticky top-0 z-50 transition-all duration-300 ${scrolled ? "bg-card shadow-lg" : "bg-card/95 backdrop-blur-md"}`}>
        <div className="container mx-auto flex items-center justify-between py-3 px-4">
          <Link to="/" className="flex items-center gap-3">
            <img src={logo} alt="Nagashree English School logo" className="w-12 h-12 object-contain" />
            <div>
              <span className="font-display font-bold text-lg text-primary leading-tight block">Nagashree English School</span>
              <span className="text-xs text-muted-foreground">Channarayapatna, Hassan</span>
            </div>
          </Link>

          {/* Desktop nav */}
          <nav className="hidden lg:flex items-center gap-1" aria-label="Main navigation">
            {navLinks.map((link) => (
              <Link
                key={link.path}
                to={link.path}
                className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
                  location.pathname === link.path
                    ? "bg-secondary text-secondary-foreground"
                    : "text-foreground hover:bg-muted"
                }`}
              >
                {link.label}
              </Link>
            ))}
          </nav>

          {/* Mobile toggle */}
          <button
            className="lg:hidden p-2 text-foreground"
            onClick={() => setMobileOpen(!mobileOpen)}
            aria-label={mobileOpen ? "Close menu" : "Open menu"}
          >
            {mobileOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
          </button>
        </div>

        {/* Mobile nav */}
        {mobileOpen && (
          <nav className="lg:hidden border-t border-border bg-card px-4 pb-4" aria-label="Mobile navigation">
            {navLinks.map((link) => (
              <Link
                key={link.path}
                to={link.path}
                className={`block px-4 py-3 rounded-lg text-sm font-medium transition-colors ${
                  location.pathname === link.path
                    ? "bg-secondary text-secondary-foreground"
                    : "text-foreground hover:bg-muted"
                }`}
              >
                {link.label}
              </Link>
            ))}
          </nav>
        )}
      </header>
    </>
  );
};

export default SiteHeader;
