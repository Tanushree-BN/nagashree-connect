import { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { X } from "lucide-react";
import SiteHeader from "@/components/SiteHeader";
import SiteFooter from "@/components/SiteFooter";
import HeroBanner from "@/components/HeroBanner";
import { galleryCategories } from "@/data/schoolData";
import { getGalleryImages } from "@/lib/store";

const Gallery = () => {
  const [activeCategory, setActiveCategory] = useState<string>("all");
  const [lightboxIndex, setLightboxIndex] = useState<number | null>(null);
  const allImages = getGalleryImages();
  const filtered = activeCategory === "all" ? allImages : allImages.filter((item) => item.category === activeCategory);

  return (
    <>
      <SiteHeader />
      <HeroBanner title="Gallery" breadcrumb="Gallery" />
      <main className="section-padding bg-background">
        <div className="container mx-auto">
          <div className="flex flex-wrap justify-center gap-3 mb-12">
            {galleryCategories.map((cat) => (
              <button
                key={cat}
                onClick={() => setActiveCategory(cat)}
                className={`px-5 py-2.5 rounded-lg text-sm font-medium capitalize transition-colors ${
                  activeCategory === cat ? "bg-secondary text-secondary-foreground" : "bg-muted text-muted-foreground hover:bg-border"
                }`}
              >
                {cat}
              </button>
            ))}
          </div>
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <AnimatePresence mode="popLayout">
              {filtered.map((item, i) => (
                <motion.button
                  key={item.id}
                  layout
                  initial={{ opacity: 0, scale: 0.9 }}
                  animate={{ opacity: 1, scale: 1 }}
                  exit={{ opacity: 0, scale: 0.9 }}
                  transition={{ delay: i * 0.05 }}
                  onClick={() => setLightboxIndex(i)}
                  className="aspect-square rounded-xl overflow-hidden bg-muted group relative focus:outline-none focus:ring-2 focus:ring-ring"
                >
                  <img src={item.src} alt={item.alt} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" />
                  <div className="absolute inset-0 bg-navy-dark/0 group-hover:bg-navy-dark/50 transition-colors flex items-end p-4">
                    <span className="text-primary-foreground font-medium text-sm opacity-0 group-hover:opacity-100 transition-opacity">{item.title}</span>
                  </div>
                </motion.button>
              ))}
            </AnimatePresence>
          </div>
        </div>
      </main>
      <AnimatePresence>
        {lightboxIndex !== null && (
          <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} exit={{ opacity: 0 }} className="fixed inset-0 z-[100] bg-navy-dark/95 flex items-center justify-center p-4" onClick={() => setLightboxIndex(null)}>
            <button onClick={() => setLightboxIndex(null)} className="absolute top-6 right-6 text-primary-foreground/70 hover:text-primary-foreground" aria-label="Close lightbox">
              <X className="w-8 h-8" />
            </button>
            <img src={filtered[lightboxIndex]?.src} alt={filtered[lightboxIndex]?.alt} className="max-w-full max-h-[85vh] rounded-xl object-contain" onClick={(e) => e.stopPropagation()} />
            <p className="absolute bottom-8 text-primary-foreground font-display text-lg">{filtered[lightboxIndex]?.title}</p>
          </motion.div>
        )}
      </AnimatePresence>
      <SiteFooter />
    </>
  );
};

export default Gallery;
