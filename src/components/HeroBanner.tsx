import { Link } from "react-router-dom";

interface HeroBannerProps {
  title: string;
  breadcrumb: string;
}

const HeroBanner = ({ title, breadcrumb }: HeroBannerProps) => {
  return (
    <section className="gradient-navy py-16 md:py-20 px-4">
      <div className="container mx-auto text-center">
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
