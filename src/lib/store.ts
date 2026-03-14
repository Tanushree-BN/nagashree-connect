// localStorage-based store for admin CRUD operations

export interface GalleryImage {
  id: string;
  src: string;
  alt: string;
  category: string;
  title: string;
}

export interface FacultyMember {
  id: string;
  name: string;
  role: string;
  subject: string;
  experience: string;
}

export interface ContactMessage {
  id: string;
  name: string;
  email: string;
  phone: string;
  subject: string;
  message: string;
  date: string;
  seen: boolean;
}

export interface AdmissionForm {
  id: string;
  studentName: string;
  parentName: string;
  dob: string;
  gender: string;
  classApplying: string;
  phone: string;
  email: string;
  address: string;
  previousSchool: string;
  previousGrade: string;
  aadhaar: string;
  date: string;
  seen: boolean;
}

const KEYS = {
  gallery: "nagashree_gallery",
  faculties: "nagashree_faculties",
  messages: "nagashree_messages",
  admissions: "nagashree_admissions",
};

function get<T>(key: string, fallback: T[]): T[] {
  try {
    const data = localStorage.getItem(key);
    return data ? JSON.parse(data) : fallback;
  } catch {
    return fallback;
  }
}

function set<T>(key: string, data: T[]) {
  localStorage.setItem(key, JSON.stringify(data));
}

// Default data
import { galleryItems as defaultGallery, faculties as defaultFaculties } from "@/data/schoolData";

const defaultGalleryWithIds: GalleryImage[] = defaultGallery.map((g, i) => ({ ...g, id: `g-${i}` }));
const defaultFacultiesWithIds: FacultyMember[] = defaultFaculties.map((f, i) => ({ ...f, id: `f-${i}` }));

// Gallery
export const getGalleryImages = (): GalleryImage[] => get(KEYS.gallery, defaultGalleryWithIds);
export const saveGalleryImages = (images: GalleryImage[]) => set(KEYS.gallery, images);
export const addGalleryImage = (image: Omit<GalleryImage, "id">) => {
  const images = getGalleryImages();
  images.push({ ...image, id: `g-${Date.now()}` });
  saveGalleryImages(images);
};
export const updateGalleryImage = (id: string, data: Partial<GalleryImage>) => {
  const images = getGalleryImages().map((img) => (img.id === id ? { ...img, ...data } : img));
  saveGalleryImages(images);
};
export const deleteGalleryImage = (id: string) => {
  saveGalleryImages(getGalleryImages().filter((img) => img.id !== id));
};

// Faculties
export const getFaculties = (): FacultyMember[] => get(KEYS.faculties, defaultFacultiesWithIds);
export const saveFaculties = (faculties: FacultyMember[]) => set(KEYS.faculties, faculties);
export const addFaculty = (faculty: Omit<FacultyMember, "id">) => {
  const list = getFaculties();
  list.push({ ...faculty, id: `f-${Date.now()}` });
  saveFaculties(list);
};
export const updateFaculty = (id: string, data: Partial<FacultyMember>) => {
  saveFaculties(getFaculties().map((f) => (f.id === id ? { ...f, ...data } : f)));
};
export const deleteFaculty = (id: string) => {
  saveFaculties(getFaculties().filter((f) => f.id !== id));
};

// Messages
export const getMessages = (): ContactMessage[] => get(KEYS.messages, []);
export const addMessage = (msg: Omit<ContactMessage, "id" | "date" | "seen">) => {
  const list = getMessages();
  list.unshift({ ...msg, id: `m-${Date.now()}`, date: new Date().toISOString(), seen: false });
  set(KEYS.messages, list);
};
export const markMessageSeen = (id: string) => {
  set(KEYS.messages, getMessages().map((m) => (m.id === id ? { ...m, seen: true } : m)));
};
export const deleteMessage = (id: string) => {
  set(KEYS.messages, getMessages().filter((m) => m.id !== id));
};

// Admissions
export const getAdmissions = (): AdmissionForm[] => get(KEYS.admissions, []);
export const addAdmission = (form: Omit<AdmissionForm, "id" | "date" | "seen">) => {
  const list = getAdmissions();
  list.unshift({ ...form, id: `a-${Date.now()}`, date: new Date().toISOString(), seen: false });
  set(KEYS.admissions, list);
};
export const markAdmissionSeen = (id: string) => {
  set(KEYS.admissions, getAdmissions().map((a) => (a.id === id ? { ...a, seen: true } : a)));
};
export const deleteAdmission = (id: string) => {
  set(KEYS.admissions, getAdmissions().filter((a) => a.id !== id));
};
