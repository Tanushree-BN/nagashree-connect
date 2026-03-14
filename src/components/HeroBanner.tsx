import { Link } from "react-router-dom";

interface HeroBannerProps {
  title: string;
  breadcrumb: string;
}

const HeroBanner = ({ title, breadcrumb }: HeroBannerProps) => {
  return (
    <section className="relative py-16 md:py-20 px-4 overflow-hidden">
      <div className="absolute inset-0">
        <img src="/images/bg1.JPG" alt="Background" className="w-full h-full object-cover" loading="eager" fetchPriority="high" />
        <div className="absolute inset-0 bg-navy-dark/80 backdrop-blur-[2px]" />
      </div>
      <div className="container mx-auto text-center relative z-10">
        <h1 className="font-display text-3xl md:text-5xl font-bold text-primary-foreground mb-4">
          {title}
        </h1>
        <div className="flex items-center justify-center gap-2 text-primary-foreground/60 text-sm">
          <Link to="/" className="hover:text-gold transition-colors">Home</Link>
          <span>/</span>
          <span className="text-gold">{breadcrumb}</span>
        </div>
      </div>
    </section>
  );
};

export default HeroBanner;
