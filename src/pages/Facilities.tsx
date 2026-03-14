import { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { X, Monitor, FlaskConical, Library, Laptop, Dumbbell, Bus, CheckCircle } from "lucide-react";
import SiteHeader from "@/components/SiteHeader";
import SiteFooter from "@/components/SiteFooter";
import HeroBanner from "@/components/HeroBanner";
import { facilities } from "@/data/schoolData";

const iconMap: Record<string, React.ReactNode> = {
  Monitor: <Monitor className="w-8 h-8" />,
  FlaskConical: <FlaskConical className="w-8 h-8" />,
  Library: <Library className="w-8 h-8" />,
  Laptop: <Laptop className="w-8 h-8" />,
  Dumbbell: <Dumbbell className="w-8 h-8" />,
  Bus: <Bus className="w-8 h-8" />,
};

const Facilities = () => {
  const [openFacility, setOpenFacility] = useState<string | null>(null);
  const activeFacility = facilities.find((f) => f.id === openFacility);

  return (
    <>
      <SiteHeader />
      <HeroBanner title="Our Facilities" breadcrumb="Facilities" />
      <main className="section-padding bg-background">
        <div className="container mx-auto">
          <div className="text-center mb-14">
            <h2 className="section-title">World-Class Infrastructure</h2>
            <p className="section-subtitle mx-auto">
              Our campus is designed to provide a modern, safe, and inspiring learning environment for every student.
            </p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {facilities.map((facility, i) => (
              <motion.button
                key={facility.id}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.08 }}
                onClick={() => setOpenFacility(facility.id)}
                className="bg-card rounded-xl overflow-hidden card-hover border border-border text-left focus:outline-none focus:ring-2 focus:ring-ring group flex flex-col"
              >
                <div className="h-48 w-full overflow-hidden relative">
                  <img src={facility.image} alt={facility.title} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" />
                  <div className="absolute top-4 right-4 w-12 h-12 rounded-xl bg-card/90 backdrop-blur-sm text-gold flex items-center justify-center shadow-lg">
                    {iconMap[facility.icon]}
                  </div>
                </div>
                <div className="p-6 flex-1 flex flex-col">
                  <h3 className="font-display text-xl font-semibold text-foreground mb-2">{facility.title}</h3>
                  <p className="text-muted-foreground text-sm leading-relaxed flex-1">{facility.shortDesc}</p>
                  <span className="inline-block mt-4 text-gold text-sm font-medium">Learn more →</span>
                </div>
              </motion.button>
            ))}
          </div>
        </div>
      </main>

      {/* Modal */}
      <AnimatePresence>
        {activeFacility && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            className="fixed inset-0 z-[100] bg-navy-dark/60 backdrop-blur-sm flex items-center justify-center p-4"
            onClick={() => setOpenFacility(null)}
          >
            <motion.div
              initial={{ opacity: 0, scale: 0.95, y: 20 }}
              animate={{ opacity: 1, scale: 1, y: 0 }}
              exit={{ opacity: 0, scale: 0.95, y: 20 }}
              onClick={(e) => e.stopPropagation()}
              className="bg-card rounded-2xl p-8 max-w-lg w-full shadow-xl relative"
              role="dialog"
              aria-label={activeFacility.title}
            >
              <button
                onClick={() => setOpenFacility(null)}
                className="absolute top-4 right-4 text-muted-foreground hover:text-foreground z-10 bg-card rounded-full p-1 shadow-md"
                aria-label="Close"
              >
                <X className="w-5 h-5" />
              </button>
              <div className="h-48 -mt-8 -mx-8 mb-6 overflow-hidden rounded-t-2xl relative">
                <img src={activeFacility.image} alt={activeFacility.title} className="w-full h-full object-cover" />
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent" />
                <div className="absolute bottom-4 left-6 flex items-center gap-3">
                  <div className="w-10 h-10 rounded-lg bg-gold text-secondary-foreground flex items-center justify-center shadow-lg">
                    {iconMap[activeFacility.icon]}
                  </div>
                  <h3 className="font-display text-2xl font-bold text-white">{activeFacility.title}</h3>
                </div>
              </div>
              <ul className="space-y-3">
                {activeFacility.details.map((detail) => (
                  <li key={detail} className="flex items-start gap-3 text-muted-foreground text-sm">
                    <CheckCircle className="w-4 h-4 text-gold shrink-0 mt-0.5" />
                    {detail}
                  </li>
                ))}
              </ul>
            </motion.div>
          </motion.div>
        )}
      </AnimatePresence>

      <SiteFooter />
    </>
  );
};

export default Facilities;
