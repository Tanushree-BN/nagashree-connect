# Nagashree English School Website

## Overview

This is the official web application for **Nagashree English School**, located in Channarayapatna, Hassan, Karnataka. It provides a platform for prospective parents and students to learn about the school's facilities, faculties, admission process, gallery, and contact details.

The project also features a secure **Admin Dashboard** for managing website content, monitoring admission inquiries, and updating faculties and the gallery.

## Features

- **Public Website**: Modern, mobile-responsive pages including Home, About, Gallery, Faculties, Facilities, Contact, and Admission.
- **Admin Dashboard**: Secure login area to manage gallery images, faculty information, user messages, and admission applications.
- **Modern UI**: Designed with a premium look and feel, utilizing Tailwind CSS and Radix UI primitives via Shadcn UI.
- **Performance Optimized**: Configured for fast load times using Vite and React.
- **Form Handling**: Integrated with React Hook Form, Input OTP, and Zod for robust data validation.
- **Routing**: Seamless client-side routing with React Router v6.

## Technology Stack

- **Frontend Framework**: React 18 with TypeScript
- **Build Tool**: Vite
- **Styling**: Tailwind CSS, class-variance-authority, clsx, tailwind-merge
- **UI Architecture**: Radix UI / Shadcn UI components
- **Icons**: Lucide React
- **Animations**: Framer Motion
- **Forms & Validation**: React Hook Form, Zod
- **Data Fetching & State**: React Query (@tanstack/react-query)
- **Testing**: Vitest, Playwright

## Folder Structure

- `src/components/` - Reusable UI components (including Shadcn components).
- `src/pages/` - Application pages (Index, About, Admission, Contact, Gallery, etc.).
- `src/pages/admin/` - Admin dashboard pages (AdminLayout, AdminGallery, AdminAdmissions, etc.).
- `src/hooks/` - Custom React hooks.
- `src/lib/` - Utility functions.
- `src/assets/` - Static assets including images.
- `public/` - Public facing assets such as the favicon.

## Getting Started

### Prerequisites

- Node.js (v18 or higher recommended)
- npm, yarn, pnpm, or bun

### Installation

1. Clone the repository to your local machine.
2. Install the project dependencies:
   ```bash
   npm install
   # or yarn / pnpm / bun install
   ```

### Development

Start the Vite development server:

```bash
npm run dev
```

The application will typically be available at `http://localhost:5173`.

### Production Build

Build the application for production:

```bash
npm run build
```

To preview the production build locally:

```bash
npm run preview
```

### Testing

- Run Unit Tests (`Vitest`):
  ```bash
  npm run test
  ```
- Run End-to-End Tests (`Playwright`):
  ```bash
  npx playwright test
  ```

## Scripts Overview

- `dev`: Starts the local development server.
- `build`: Compiles the TypeScript code and produces a production-ready bundle.
- `lint`: Checks for code quality and style issues using ESLint.
- `preview`: Serves the production bundle locally for testing.
- `test`: Executes the Vitest test suite.
- `test:watch`: Runs tests in interactive watch mode.
