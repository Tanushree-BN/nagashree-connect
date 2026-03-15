import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { Toaster } from "@/components/ui/toaster";
import { TooltipProvider } from "@/components/ui/tooltip";
import Index from "./pages/Index";
import About from "./pages/About";
import Gallery from "./pages/Gallery";
import Faculties from "./pages/Faculties";
import Facilities from "./pages/Facilities";
import Contact from "./pages/Contact";
import Admission from "./pages/Admission";
import AdminLogin from "./pages/AdminLogin";
import AdminLayout from "./pages/admin/AdminLayout";
import AdminGallery from "./pages/admin/AdminGallery";
import AdminFaculties from "./pages/admin/AdminFaculties";
import AdminMessages from "./pages/admin/AdminMessages";
import AdminAdmissions from "./pages/admin/AdminAdmissions";
import NotFound from "./pages/NotFound";

const queryClient = new QueryClient();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Index />} />
          <Route path="/about" element={<About />} />
          <Route path="/gallery" element={<Gallery />} />
          <Route path="/faculties" element={<Faculties />} />
          <Route path="/facilities" element={<Facilities />} />
          <Route path="/contact" element={<Contact />} />
          <Route path="/admission" element={<Admission />} />
          <Route path="/admin/login" element={<AdminLogin />} />
          <Route path="/admin" element={<AdminLayout />}>
            <Route path="dashboard" element={<AdminGallery />} />
            <Route path="gallery" element={<AdminGallery />} />
            <Route path="faculties" element={<AdminFaculties />} />
            <Route path="messages" element={<AdminMessages />} />
            <Route path="admissions" element={<AdminAdmissions />} />
          </Route>
          <Route path="*" element={<NotFound />} />
        </Routes>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;
