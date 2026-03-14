import { useEffect } from "react";
import { Link, Outlet, useNavigate, useLocation } from "react-router-dom";
import { Image, Users, MessageSquare, FileText, LogOut, Home } from "lucide-react";

const navItems = [
  { label: "Gallery", path: "/admin/gallery", icon: <Image className="w-4 h-4" /> },
  { label: "Faculties", path: "/admin/faculties", icon: <Users className="w-4 h-4" /> },
  { label: "Messages", path: "/admin/messages", icon: <MessageSquare className="w-4 h-4" /> },
  { label: "Admissions", path: "/admin/admissions", icon: <FileText className="w-4 h-4" /> },
];

const AdminLayout = () => {
  const navigate = useNavigate();
  const location = useLocation();

  useEffect(() => {
    if (sessionStorage.getItem("nagashree_admin") !== "true") {
      navigate("/admin");
    }
  }, [navigate]);

  const handleLogout = () => {
    sessionStorage.removeItem("nagashree_admin");
    navigate("/admin");
  };

  return (
    <div className="min-h-screen bg-muted flex">
      {/* Sidebar */}
      <aside className="w-64 gradient-navy text-primary-foreground flex flex-col shrink-0">
        <div className="p-6 border-b border-primary-foreground/10">
          <h2 className="font-display text-lg font-bold">Admin Panel</h2>
          <p className="text-primary-foreground/60 text-xs mt-1">Nagashree English School</p>
        </div>
        <nav className="flex-1 p-4 space-y-1">
          {navItems.map((item) => (
            <Link
              key={item.path}
              to={item.path}
              className={`flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors ${
                location.pathname === item.path
                  ? "bg-gold text-secondary-foreground"
                  : "text-primary-foreground/70 hover:bg-primary-foreground/10"
              }`}
            >
              {item.icon}
              {item.label}
            </Link>
          ))}
        </nav>
        <div className="p-4 space-y-1 border-t border-primary-foreground/10">
          <Link to="/" className="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-primary-foreground/70 hover:bg-primary-foreground/10 transition-colors">
            <Home className="w-4 h-4" /> View Website
          </Link>
          <button onClick={handleLogout} className="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-primary-foreground/70 hover:bg-primary-foreground/10 transition-colors w-full">
            <LogOut className="w-4 h-4" /> Logout
          </button>
        </div>
      </aside>

      {/* Main */}
      <main className="flex-1 p-8 overflow-auto">
        <Outlet />
      </main>
    </div>
  );
};

export default AdminLayout;
