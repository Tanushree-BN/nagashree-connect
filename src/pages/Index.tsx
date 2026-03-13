import { Link } from "react-router-dom";
import { motion } from "framer-motion";
import { BookOpen, Users, Shield, Trophy, Monitor, Bus, ArrowRight, GraduationCap } from "lucide-react";
import SiteHeader from "@/components/SiteHeader";
import SiteFooter from "@/components/SiteFooter";
import StatCounter from "@/components/StatCounter";
import { features, stats, contactInfo } from "@/data/schoolData";
import heroImg from "@/assets/hero-school.jpg";
import aboutImg from "@/assets/about-school.jpg";

const iconMap: Record<string, React.ReactNode> = {
  BookOpen: <BookOpen className="w-8 h-8" />,
  Users: <Users className="w-8 h-8" />,
  Shield: <Shield className="w-8 h-8" />,
  Trophy: <Trophy className="w-8 h-8" />,
  Monitor: <Monitor className="w-8 h-8" />,
  Bus: <Bus className="w-8 h-8" />,
};

const Index = () => {
  return (
    <>
      <SiteHeader />
      <main>
        {/* Hero */}
        <section className="relative min-h-[85vh] flex items-center overflow-hidden">
          <div className="absolute inset-0">
            <img src={heroImg} alt="Nagashree English School campus aerial view with students playing" className="w-full h-full object-cover" />
            <div className="absolute inset-0 bg-gradient-to-r from-navy-dark/90 via-navy-dark/70 to-navy-dark/40" />
          </div>
          <div className="container mx-auto px-4 relative z-10">
            <motion.div
              initial={{ opacity: 0, y: 40 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8 }}
              className="max-w-2xl"
            >
              <span className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gold/20 text-gold text-sm font-medium mb-6 border border-gold/30">
                <GraduationCap className="w-4 h-4" />
                Admissions Open 2025-26
              </span>
              <h1 className="font-display text-4xl md:text-6xl lg:text-7xl font-bold text-primary-foreground leading-tight mb-6">
                Shaping <span className="text-gold">Bright</span> Futures Together
              </h1>
              <p className="text-primary-foreground/80 text-lg md:text-xl mb-8 leading-relaxed">
                At Nagashree English School, we nurture young minds with quality education, strong values, and holistic development in a safe, inspiring environment.
              </p>
              <div className="flex flex-wrap gap-4">
                <Link
                  to="/contact"
                  className="inline-flex items-center gap-2 px-8 py-4 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors"
                >
                  Enquire Now <ArrowRight className="w-4 h-4" />
                </Link>
                <Link
                  to="/about"
                  className="inline-flex items-center gap-2 px-8 py-4 rounded-lg border-2 border-primary-foreground/30 text-primary-foreground font-semibold hover:bg-primary-foreground/10 transition-colors"
                >
                  Explore Our School
                </Link>
              </div>
            </motion.div>
          </div>
        </section>

        {/* Why Choose Us */}
        <section className="section-padding bg-background">
          <div className="container mx-auto">
            <div className="text-center mb-14">
              <h2 className="section-title">Why Choose Nagashree?</h2>
              <p className="section-subtitle mx-auto">
                We provide a nurturing environment where every child can thrive academically, socially, and personally.
              </p>
            </div>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {features.map((feature, i) => (
                <motion.div
                  key={feature.title}
                  initial={{ opacity: 0, y: 30 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  viewport={{ once: true }}
                  transition={{ delay: i * 0.1 }}
                  className="bg-card rounded-xl p-8 card-hover border border-border"
                >
                  <div className="w-14 h-14 rounded-xl bg-gold/10 text-gold flex items-center justify-center mb-5">
                    {iconMap[feature.icon]}
                  </div>
                  <h3 className="font-display text-xl font-semibold text-foreground mb-3">{feature.title}</h3>
                  <p className="text-muted-foreground text-sm leading-relaxed">{feature.description}</p>
                </motion.div>
              ))}
            </div>
          </div>
        </section>

        {/* Admissions Banner */}
        <section className="gradient-navy section-padding">
          <div className="container mx-auto text-center">
            <motion.div
              initial={{ opacity: 0, scale: 0.95 }}
              whileInView={{ opacity: 1, scale: 1 }}
              viewport={{ once: true }}
            >
              <span className="text-gold font-semibold text-sm uppercase tracking-widest">Now Enrolling</span>
              <h2 className="font-display text-3xl md:text-5xl font-bold text-primary-foreground mt-4 mb-6">
                Admissions Open for 2025-26
              </h2>
              <p className="text-primary-foreground/70 text-lg max-w-xl mx-auto mb-8">
                Give your child the gift of quality education. Limited seats available — apply now to secure your spot.
              </p>
              <div className="flex flex-wrap justify-center gap-4">
                <Link
                  to="/contact"
                  className="inline-flex items-center gap-2 px-8 py-4 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors"
                >
                  Apply Now <ArrowRight className="w-4 h-4" />
                </Link>
                <a
                  href={`tel:${contactInfo.phones.office}`}
                  className="inline-flex items-center gap-2 px-8 py-4 rounded-lg border-2 border-primary-foreground/30 text-primary-foreground font-semibold hover:bg-primary-foreground/10 transition-colors"
                >
                  Call Us: {contactInfo.phones.office}
                </a>
              </div>
            </motion.div>
          </div>
        </section>

        {/* About Preview */}
        <section className="section-padding bg-muted">
          <div className="container mx-auto">
            <div className="grid lg:grid-cols-2 gap-12 items-center">
              <motion.div
                initial={{ opacity: 0, x: -40 }}
                whileInView={{ opacity: 1, x: 0 }}
                viewport={{ once: true }}
              >
                <img
                  src={aboutImg}
                  alt="Nagashree English School campus building"
                  className="rounded-2xl shadow-lg w-full object-cover aspect-[4/3]"
                  loading="lazy"
                />
              </motion.div>
              <motion.div
                initial={{ opacity: 0, x: 40 }}
                whileInView={{ opacity: 1, x: 0 }}
                viewport={{ once: true }}
              >
                <span className="text-gold font-semibold text-sm uppercase tracking-widest">About Us</span>
                <h2 className="section-title mt-3 mb-6">Nurturing Excellence Since 2009</h2>
                <p className="text-muted-foreground leading-relaxed mb-4">
                  Nagashree English School, located in the heart of Channarayapatna, Hassan, is committed to providing a world-class education that balances academic rigor with character development.
                </p>
                <p className="text-muted-foreground leading-relaxed mb-6">
                  Our experienced faculty, modern infrastructure, and vibrant campus life create the perfect environment for every student to discover their potential and excel.
                </p>
                <Link
                  to="/about"
                  className="inline-flex items-center gap-2 text-gold font-semibold hover:text-gold-dark transition-colors"
                >
                  Learn More About Us <ArrowRight className="w-4 h-4" />
                </Link>
              </motion.div>
            </div>
          </div>
        </section>

        {/* Stats */}
        <section className="gradient-navy section-padding">
          <div className="container mx-auto">
            <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
              {stats.map((stat) => (
                <StatCounter key={stat.label} value={stat.value} suffix={stat.suffix} label={stat.label} />
              ))}
            </div>
          </div>
        </section>

        {/* Gallery Preview */}
        <section className="section-padding bg-background">
          <div className="container mx-auto text-center">
            <h2 className="section-title mb-4">Campus Life</h2>
            <p className="section-subtitle mx-auto mb-10">A glimpse into the vibrant life at Nagashree English School.</p>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
              {[1, 2, 3, 4].map((i) => (
                <div key={i} className="aspect-square rounded-xl overflow-hidden bg-muted">
                  <img src="/placeholder.svg" alt={`School campus life photo ${i}`} className="w-full h-full object-cover hover:scale-105 transition-transform duration-500" loading="lazy" />
                </div>
              ))}
            </div>
            <Link
              to="/gallery"
              className="inline-flex items-center gap-2 mt-8 text-gold font-semibold hover:text-gold-dark transition-colors"
            >
              View Full Gallery <ArrowRight className="w-4 h-4" />
            </Link>
          </div>
        </section>
      </main>
      <SiteFooter />
    </>
  );
};

export default Index;
