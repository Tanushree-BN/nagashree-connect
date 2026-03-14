import { Link } from "react-router-dom";
import { motion } from "framer-motion";
import {
  BookOpen, Users, Shield, Trophy, Monitor, Bus, ArrowRight, GraduationCap,
  Sparkles, Clock, Building, Lightbulb, Dumbbell, Play,
} from "lucide-react";
import SiteHeader from "@/components/SiteHeader";
import SiteFooter from "@/components/SiteFooter";
import StatCounter from "@/components/StatCounter";
import { features, offerings, stats, contactInfo, schoolDescription } from "@/data/schoolData";
import { getGalleryImages } from "@/lib/store";
import { useState } from "react";

const iconMap: Record<string, React.ReactNode> = {
  BookOpen: <BookOpen className="w-8 h-8" />,
  Users: <Users className="w-8 h-8" />,
  Shield: <Shield className="w-8 h-8" />,
  Trophy: <Trophy className="w-8 h-8" />,
  Monitor: <Monitor className="w-8 h-8" />,
  Bus: <Bus className="w-8 h-8" />,
  GraduationCap: <GraduationCap className="w-8 h-8" />,
  Sparkles: <Sparkles className="w-8 h-8" />,
  Clock: <Clock className="w-8 h-8" />,
  Building: <Building className="w-8 h-8" />,
  Lightbulb: <Lightbulb className="w-8 h-8" />,
  Dumbbell: <Dumbbell className="w-8 h-8" />,
};

const smallIconMap: Record<string, React.ReactNode> = {
  Shield: <Shield className="w-6 h-6" />,
  Clock: <Clock className="w-6 h-6" />,
  GraduationCap: <GraduationCap className="w-6 h-6" />,
  Building: <Building className="w-6 h-6" />,
  Lightbulb: <Lightbulb className="w-6 h-6" />,
  Dumbbell: <Dumbbell className="w-6 h-6" />,
};

const Index = () => {
  const [showVideo, setShowVideo] = useState(false);
  const galleryImages = getGalleryImages().slice(0, 4);

  return (
    <>
      <SiteHeader />
      <main>
        {/* Hero */}
        <section className="relative min-h-[85vh] flex items-center overflow-hidden">
          <div className="absolute inset-0">
            <img src="/images/clg1.JPG" alt="Nagashree English School campus" className="w-full h-full object-cover" loading="eager" fetchPriority="high" />
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
                Welcome To
              </span>
              <h1 className="font-display text-4xl md:text-6xl lg:text-7xl font-bold text-primary-foreground leading-tight mb-6">
                Nagashree <span className="text-gold">English</span> School
              </h1>
              <p className="text-primary-foreground/80 text-lg md:text-xl mb-8 leading-relaxed">
                At Nagashree English School, we nurture young minds with quality education, strong values, and holistic development in a safe, inspiring environment.
              </p>
              <div className="flex flex-wrap gap-4">
                <Link
                  to="/admission"
                  className="inline-flex items-center gap-2 px-8 py-4 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors"
                >
                  Admission Open <ArrowRight className="w-4 h-4" />
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

        {/* Feature Cards - Certified Teachers, Special Education, etc */}
        <section className="section-padding bg-background">
          <div className="container mx-auto">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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

        {/* What We Offer */}
        <section className="section-padding bg-muted">
          <div className="container mx-auto">
            <div className="grid lg:grid-cols-2 gap-12 items-center">
              <motion.div
                initial={{ opacity: 0, x: -40 }}
                whileInView={{ opacity: 1, x: 0 }}
                viewport={{ once: true }}
              >
                <img
                  src="/images/RKP_9725.JPG"
                  alt="What we offer at Nagashree English School"
                  className="rounded-2xl shadow-lg w-full object-cover aspect-[4/3] object-top"
                  loading="lazy"
                  decoding="async"
                />
              </motion.div>
              <motion.div
                initial={{ opacity: 0, x: 40 }}
                whileInView={{ opacity: 1, x: 0 }}
                viewport={{ once: true }}
              >
                <span className="text-gold font-semibold text-sm uppercase tracking-widest">What We Offer</span>
                <h2 className="section-title mt-3 mb-6">Quality Education & Holistic Growth</h2>
                <p className="text-muted-foreground leading-relaxed mb-6">
                  On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word.
                </p>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  {offerings.map((item) => (
                    <div key={item.title} className="flex items-start gap-3">
                      <div className="w-10 h-10 rounded-lg bg-gold/10 text-gold flex items-center justify-center shrink-0 mt-0.5">
                        {smallIconMap[item.icon]}
                      </div>
                      <div>
                        <h4 className="font-semibold text-foreground text-sm">{item.title}</h4>
                        <p className="text-muted-foreground text-xs leading-relaxed mt-1">{item.description}</p>
                      </div>
                    </div>
                  ))}
                </div>
              </motion.div>
            </div>
          </div>
        </section>

        {/* School Video + Description + Stats */}
        <section className="gradient-navy section-padding">
          <div className="container mx-auto">
            <div className="grid lg:grid-cols-2 gap-12 items-center mb-16">
              {/* Video */}
              <motion.div
                initial={{ opacity: 0, x: -30 }}
                whileInView={{ opacity: 1, x: 0 }}
                viewport={{ once: true }}
                className="relative aspect-video rounded-2xl overflow-hidden bg-navy-light"
              >
                {showVideo ? (
                  <video
                    src="/images/vedio.mp4"
                    className="w-full h-full object-cover"
                    autoPlay
                    controls
                    title="Nagashree English School video"
                  />
                ) : (
                  <button
                    onClick={() => setShowVideo(true)}
                    className="w-full h-full flex items-center justify-center group"
                  >
                    <img src="/images/bg2.JPG" alt="School video thumbnail" className="absolute inset-0 w-full h-full object-cover opacity-60" loading="lazy" decoding="async" />
                    <div className="relative w-20 h-20 rounded-full bg-gold flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                      <Play className="w-8 h-8 text-secondary-foreground ml-1" />
                    </div>
                    <span className="absolute bottom-6 left-6 text-primary-foreground font-display text-xl font-bold">
                      Nagashree English School
                    </span>
                  </button>
                )}
              </motion.div>
              {/* Description */}
              <motion.div
                initial={{ opacity: 0, x: 30 }}
                whileInView={{ opacity: 1, x: 0 }}
                viewport={{ once: true }}
              >
                <span className="text-gold font-semibold text-sm uppercase tracking-widest">About Our School</span>
                <h2 className="font-display text-3xl md:text-4xl font-bold text-primary-foreground mt-3 mb-6">
                  Nagashree English School
                </h2>
                <p className="text-primary-foreground/80 leading-relaxed text-sm">
                  {schoolDescription}
                </p>
              </motion.div>
            </div>
            {/* Stats */}
            <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
              {stats.map((stat) => (
                <StatCounter key={stat.label} value={stat.value} suffix={stat.suffix} label={stat.label} />
              ))}
            </div>
          </div>
        </section>

        {/* Campus Life Gallery */}
        <section className="section-padding bg-background">
          <div className="container mx-auto text-center">
            <h2 className="section-title mb-4">Campus Life</h2>
            <p className="section-subtitle mx-auto mb-10">A glimpse into the vibrant life at Nagashree English School.</p>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
              {galleryImages.map((img) => (
                <div key={img.id} className="aspect-square rounded-xl overflow-hidden bg-muted">
                  <img src={img.src} alt={img.alt} className="w-full h-full object-cover hover:scale-105 transition-transform duration-500" loading="lazy" />
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
