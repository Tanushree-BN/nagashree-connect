import { motion } from "framer-motion";
import { ArrowRight } from "lucide-react";
import { Link } from "react-router-dom";
import SiteHeader from "@/components/SiteHeader";
import SiteFooter from "@/components/SiteFooter";
import HeroBanner from "@/components/HeroBanner";
import StatCounter from "@/components/StatCounter";
import { stats } from "@/data/schoolData";
import aboutImg from "@/assets/about-school.jpg";

const About = () => {
  return (
    <>
      <SiteHeader />
      <HeroBanner title="About Us" breadcrumb="About" />
      <main>
        {/* Unique Story */}
        <section className="section-padding bg-background">
          <div className="container mx-auto">
            <div className="grid lg:grid-cols-2 gap-12 items-center">
              <motion.div initial={{ opacity: 0, x: -30 }} whileInView={{ opacity: 1, x: 0 }} viewport={{ once: true }}>
                <img src="/images/clg2.JPG" alt="Nagashree English School campus" className="rounded-2xl shadow-lg w-full object-cover aspect-[4/3]" loading="lazy" decoding="async" />
              </motion.div>
              <motion.div initial={{ opacity: 0, x: 30 }} whileInView={{ opacity: 1, x: 0 }} viewport={{ once: true }}>
                <span className="text-gold font-semibold text-sm uppercase tracking-widest">What Makes Us Unique</span>
                <h2 className="section-title mt-3 mb-6">What is unique about Nagashree English School</h2>
                <p className="text-muted-foreground leading-relaxed mb-4">
                  Nagashree English School is an awesome place of learning in many aspects. The beautiful, serene campus with state-of-the-art facilities, vast playgrounds, amazing Management and Staff, outstanding students and parents set it apart and it is indeed a wonderful place.
                </p>
                <p className="text-muted-foreground leading-relaxed">
                  But what makes it unique is its belief system which has enabled it to evolve as the most child-friendly atmosphere.
                </p>
              </motion.div>
            </div>
          </div>
        </section>

        {/* Vision & Mission */}
        <section className="section-padding bg-muted">
          <div className="container mx-auto">
            <div className="text-center mb-14">
              <h2 className="section-title">Our Vision & Mission</h2>
            </div>
            <div className="grid md:grid-cols-2 gap-8">
              <motion.div initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }} className="bg-card rounded-xl p-10 card-hover border border-border">
                <h3 className="font-display text-2xl font-bold text-foreground mb-4">Our Vision</h3>
                <p className="text-muted-foreground leading-relaxed">
                  To be a center of academic excellence that nurtures every child's potential, instills strong moral values, and prepares globally competent citizens who contribute positively to society.
                </p>
              </motion.div>
              <motion.div initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }} transition={{ delay: 0.1 }} className="bg-card rounded-xl p-10 card-hover border border-border">
                <h3 className="font-display text-2xl font-bold text-foreground mb-4">Our Mission</h3>
                <p className="text-muted-foreground leading-relaxed">
                  To provide a holistic, inclusive, and student-centered learning experience through innovative teaching methods, a rich curriculum, and a supportive community that empowers each student to achieve their best.
                </p>
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

        {/* CTA */}
        <section className="section-padding bg-background text-center">
          <div className="container mx-auto max-w-2xl">
            <h2 className="section-title mb-4">Join Our School Family</h2>
            <p className="text-muted-foreground text-lg mb-8">
              Discover what makes Nagashree English School the right choice for your child's education.
            </p>
            <Link to="/admission" className="inline-flex items-center gap-2 px-8 py-4 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors">
              Apply for Admission <ArrowRight className="w-4 h-4" />
            </Link>
          </div>
        </section>
      </main>
      <SiteFooter />
    </>
  );
};

export default About;
