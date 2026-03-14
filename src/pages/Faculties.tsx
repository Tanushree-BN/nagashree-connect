import { motion } from "framer-motion";
import { User } from "lucide-react";
import SiteHeader from "@/components/SiteHeader";
import SiteFooter from "@/components/SiteFooter";
import HeroBanner from "@/components/HeroBanner";
import { getFaculties } from "@/lib/store";

const Faculties = () => {
  const faculties = getFaculties();

  return (
    <>
      <SiteHeader />
      <HeroBanner title="Our Faculty" breadcrumb="Faculties" />
      <main className="section-padding bg-background">
        <div className="container mx-auto">
          <div className="text-center mb-14">
            <h2 className="section-title">Meet Our Dedicated Team</h2>
            <p className="section-subtitle mx-auto">
              Our experienced educators are passionate about nurturing each student's potential and guiding them towards success.
            </p>
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {faculties.map((faculty, i) => (
              <motion.div
                key={faculty.id}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.05 }}
                className="bg-card rounded-xl p-6 card-hover border border-border text-center"
              >
                {faculty.image ? (
                  <img src={faculty.image} alt={faculty.name} className="w-20 h-20 rounded-full object-cover mx-auto mb-4 shadow-sm border border-border" />
                ) : (
                  <div className="w-20 h-20 rounded-full bg-muted flex items-center justify-center mx-auto mb-4">
                    <User className="w-10 h-10 text-muted-foreground" />
                  </div>
                )}
                <h3 className="font-display text-lg font-semibold text-foreground">{faculty.name}</h3>
                <p className="text-gold font-medium text-sm mt-1">{faculty.role}</p>
                <p className="text-muted-foreground text-sm mt-2">{faculty.subject}</p>
                <p className="text-muted-foreground/60 text-xs mt-1">{faculty.experience} experience</p>
              </motion.div>
            ))}
          </div>
        </div>
      </main>
      <SiteFooter />
    </>
  );
};

export default Faculties;
