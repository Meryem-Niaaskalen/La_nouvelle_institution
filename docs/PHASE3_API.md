# Phase 3: API REST & Authentication ✅ COMPLETE

## Overview
Complete REST API with Sanctum authentication, all public endpoints, and admin CRUD operations.

## ✅ Completed Components

### Controllers (8 Total)

**AuthController** (`app/Http/Controllers/AuthController.php`)
- `POST /api/v1/auth/login` - Authenticate user
- `POST /api/v1/auth/logout` - Revoke current token
- `POST /api/v1/auth/refresh` - Refresh authentication token
- `GET /api/v1/auth/me` - Get current user info

**ProgramController** (`app/Http/Controllers/ProgramController.php`)
- `GET /api/v1/programs` - List all active programs
- `GET /api/v1/programs/{id}` - Get program details
- `GET /api/v1/programs/level/{level}` - Programs by level
- `POST /api/v1/admin/programs` - Create program (admin)
- `PUT /api/v1/admin/programs/{id}` - Update program (admin)
- `DELETE /api/v1/admin/programs/{id}` - Delete program (admin)

**TeacherController** (`app/Http/Controllers/TeacherController.php`)
- `GET /api/v1/teachers` - List active teachers
- `GET /api/v1/teachers/{id}` - Get teacher details
- `GET /api/v1/teachers/specialization/{spec}` - Teachers by subject
- `POST /api/v1/admin/teachers` - Create teacher (admin)
- `PUT /api/v1/admin/teachers/{id}` - Update teacher (admin)
- `DELETE /api/v1/admin/teachers/{id}` - Delete teacher (admin)

**ActivityController** (`app/Http/Controllers/ActivityController.php`)
- `GET /api/v1/activities` - List published activities
- `GET /api/v1/activities/featured` - Get featured activities
- `GET /api/v1/activities/{id}` - Activity details
- `GET /api/v1/activities/category/{slug}` - Activities by category
- `POST /api/v1/admin/activities` - Create activity (admin)
- `PUT /api/v1/admin/activities/{id}` - Update activity (admin)
- `DELETE /api/v1/admin/activities/{id}` - Delete activity (admin)

**GalleryController** (`app/Http/Controllers/GalleryController.php`)
- `GET /api/v1/gallery/categories` - List all gallery categories
- `GET /api/v1/gallery/{category}` - Category with images
- `GET /api/v1/gallery/{category}/images` - Paginated images
- `POST /api/v1/admin/gallery/categories` - Create category (admin)
- `PUT /api/v1/admin/gallery/categories/{id}` - Update category (admin)
- `DELETE /api/v1/admin/gallery/categories/{id}` - Delete category (admin)
- `POST /api/v1/admin/gallery/images` - Add image (admin)
- `PUT /api/v1/admin/gallery/images/{id}` - Update image (admin)
- `DELETE /api/v1/admin/gallery/images/{id}` - Delete image (admin)

**TestimonialController** (`app/Http/Controllers/TestimonialController.php`)
- `GET /api/v1/testimonials` - List published testimonials
- `GET /api/v1/testimonials/featured` - Featured testimonials
- `GET /api/v1/testimonials/type/{type}` - Filter by type
- `POST /api/v1/admin/testimonials` - Create testimonial (admin)
- `PUT /api/v1/admin/testimonials/{id}` - Update testimonial (admin)
- `DELETE /api/v1/admin/testimonials/{id}` - Delete testimonial (admin)

**ContactController** (`app/Http/Controllers/ContactController.php`)
- `POST /api/v1/contact/send` - Submit contact form
- `GET /api/v1/contact/info` - Get school contact info
- `GET /api/v1/admin/contact/messages` - List all messages (admin)
- `PUT /api/v1/admin/contact/messages/{id}` - Mark as read/responded (admin)
- `DELETE /api/v1/admin/contact/messages/{id}` - Delete message (admin)

**SettingController** (`app/Http/Controllers/SettingController.php`)
- `GET /api/v1/settings/public` - Public school settings
- `GET /api/v1/admin/settings` - All settings (admin)
- `PUT /api/v1/admin/settings/{key}` - Update setting (admin)

### Routes Configuration

File: `routes/api.php`

**Structure:**
```
v1/
├── /health (GET)
├── Authentication
│   ├── /auth/login (POST)
│   ├── /auth/logout (POST) - Protected
│   ├── /auth/refresh (POST) - Protected
│   └── /auth/me (GET) - Protected
├── Public Routes
│   ├── /programs (GET|show|byLevel)
│   ├── /teachers (GET|show|bySpecialization)
│   ├── /activities (GET|featured|show|byCategory)
│   ├── /gallery (categories|category|images)
│   ├── /testimonials (GET|featured|byType)
│   ├── /settings/public (GET)
│   └── /contact (send|info)
└── Admin Routes (Protected with Sanctum)
    ├── /admin/teachers (CRUD)
    ├── /admin/programs (CRUD)
    ├── /admin/activities (CRUD)
    ├── /admin/gallery (CRUD)
    ├── /admin/testimonials (CRUD)
    ├── /admin/contact/messages (CRUD)
    └── /admin/settings (GET|update)
```

## Security Features

✅ **Sanctum Authentication**
- Token-based API authentication
- Protected admin routes
- Role-based access control

✅ **Authorization Checks**
- AuthorizationException throws 403 for unauthorized access
- Permissions validated via Spatie roles

✅ **Input Validation**
- All endpoints validate incoming data
- Custom French error messages
- Type and format validation

✅ **Error Handling**
- JSON error responses
- HTTP status codes (201 for creation, 404 for not found, etc.)
- Validation error details

## API Response Format

### Success Response (200 OK)
```json
{
  "data": [...],
  "pagination": {
    "total": 10,
    "per_page": 10,
    "current_page": 1,
    "last_page": 1
  }
}
```

### Single Resource (200 OK)
```json
{
  "data": {...}
}
```

### Creation Response (201 Created)
```json
{
  "message": "Resource créé avec succès",
  "data": {...}
}
```

### Error Response (4xx/5xx)
```json
{
  "message": "Error message",
  "errors": {
    "field": ["Error details"]
  }
}
```

## Test Credentials

```
Admin User:
Email: admin@nouvelle.school
Password: password123
Token: Generated on login

Teacher:
Email: fatima.el_amrani@nouvelle.school
Password: teacher123
```

## API Testing Checklist

### Authentication Flow
✅ POST /api/v1/auth/login - Get token
✅ GET /api/v1/auth/me - Verify user info
✅ POST /api/v1/auth/refresh - Refresh token
✅ POST /api/v1/auth/logout - Revoke token

### Public Endpoints
✅ GET /api/v1/programs
✅ GET /api/v1/teachers
✅ GET /api/v1/activities
✅ GET /api/v1/gallery/categories
✅ GET /api/v1/testimonials
✅ POST /api/v1/contact/send
✅ GET /api/v1/settings/public

### Admin Endpoints (with token)
✅ POST /api/v1/admin/programs (create)
✅ PUT /api/v1/admin/programs/{id} (update)
✅ DELETE /api/v1/admin/programs/{id} (delete)
✅ [All CRUD operations for other resources]

## Database Relationships Used

- User → Teacher (one-to-one)
- Program ← ProgramSubject → Subject (many-to-many)
- Activity → ActivityCategory (many-to-one)
- GalleryImage → GalleryCategory (many-to-one)
- Teacher → User (belongs-to)
- ContactMessage (standalone)
- Testimonial (standalone)

## Performance Optimizations

✅ **Eager Loading** - Relationships loaded with `with()`
✅ **Pagination** - All list endpoints paginated (10-20 items)
✅ **Indexing** - Database indexes on frequently queried columns
✅ **Query Optimization** - Only select needed columns

## Endpoint Examples

### Login
```bash
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "admin@nouvelle.school",
  "password": "password123"
}

Response:
{
  "message": "Connexion réussie",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin",
      "email": "admin@nouvelle.school",
      "roles": ["admin"]
    },
    "token": "1|xxxx...",
    "token_type": "Bearer"
  }
}
```

### Get Programs
```bash
GET /api/v1/programs

Response:
{
  "data": [
    {
      "id": 1,
      "name": "Baccalauréat Scientifique",
      "slug": "bac-scientifique",
      "level": "lycee",
      "description": "...",
      "duration_years": 2,
      "is_active": true,
      "subjects": [...]
    }
  ],
  "pagination": {...}
}
```

### Submit Contact Form
```bash
POST /api/v1/contact/send
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "subject": "Question",
  "message": "..."
}

Response:
{
  "message": "Message envoyé avec succès",
  "data": {...}
}
```

---

**Status**: ✅ COMPLETE (100%)
**Next Phase**: Phase 4 - Design System & Vue Components
