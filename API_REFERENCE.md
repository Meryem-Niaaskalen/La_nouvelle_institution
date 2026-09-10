# API Quick Reference

## BASE URL
```
http://localhost:8000/api/v1
```

## HEALTH CHECK
```bash
GET /health
```

---

## AUTHENTICATION

### Login
```bash
POST /auth/login
{
  "email": "admin@nouvelle.school",
  "password": "password123"
}
```
**Returns:** Token (use in Authorization header)

### Current User
```bash
GET /auth/me
Headers: Authorization: Bearer {token}
```

### Refresh Token
```bash
POST /auth/refresh
Headers: Authorization: Bearer {token}
```

### Logout
```bash
POST /auth/logout
Headers: Authorization: Bearer {token}
```

---

## PUBLIC ENDPOINTS

### Programs
```bash
GET /programs                                # All active programs
GET /programs/{id}                          # Program details
GET /programs/level/lycee                   # Filter by level
```

### Teachers
```bash
GET /teachers                               # List teachers
GET /teachers/{id}                          # Teacher details
GET /teachers/specialization/Mathématiques  # Filter by subject
```

### Activities
```bash
GET /activities                             # All published activities
GET /activities/featured                    # Featured only
GET /activities/{id}                        # Activity details
GET /activities/category/sports             # Filter by category
```

### Gallery
```bash
GET /gallery/categories                     # All categories
GET /gallery/{categoryId}                   # Category with images
GET /gallery/{categoryId}/images             # Paginated images
```

### Testimonials
```bash
GET /testimonials                           # All published
GET /testimonials/featured                  # Featured only
GET /testimonials/type/parent               # Filter by type
```

### Contact & Info
```bash
POST /contact/send                          # Submit form
GET /contact/info                           # School info
GET /settings/public                        # Public settings
```

---

## ADMIN ENDPOINTS (Require Auth + admin role)

### Teachers Management
```bash
POST /admin/teachers              # Create
PUT /admin/teachers/{id}          # Update
DELETE /admin/teachers/{id}       # Delete
```

### Programs Management
```bash
POST /admin/programs              # Create
PUT /admin/programs/{id}          # Update
DELETE /admin/programs/{id}       # Delete
```

### Activities Management
```bash
POST /admin/activities            # Create
PUT /admin/activities/{id}        # Update
DELETE /admin/activities/{id}     # Delete
```

### Gallery Management
```bash
POST /admin/gallery/categories        # Create category
PUT /admin/gallery/categories/{id}    # Update category
DELETE /admin/gallery/categories/{id} # Delete category

POST /admin/gallery/images            # Add image
PUT /admin/gallery/images/{id}        # Update image
DELETE /admin/gallery/images/{id}     # Delete image
```

### Testimonials Management
```bash
POST /admin/testimonials          # Create
PUT /admin/testimonials/{id}      # Update
DELETE /admin/testimonials/{id}   # Delete
```

### Contact Management
```bash
GET /admin/contact/messages              # All messages
PUT /admin/contact/messages/{id}         # Mark read/responded
DELETE /admin/contact/messages/{id}      # Delete
```

### Settings Management
```bash
GET /admin/settings               # Get all
PUT /admin/settings/{key}         # Update setting
```

---

## HTTP HEADERS

### All Requests
```
Content-Type: application/json
Accept: application/json
```

### Protected Routes (add token)
```
Authorization: Bearer {token}
```

---

## RESPONSE CODES

| Code | Meaning |
|------|---------|
| 200 | OK |
| 201 | Created |
| 400 | Bad Request |
| 401 | Unauthorized (missing token) |
| 403 | Forbidden (no permission) |
| 404 | Not Found |
| 422 | Validation Error |
| 500 | Server Error |

---

## EXAMPLE REQUESTS

### Login
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@nouvelle.school",
    "password": "password123"
  }'
```

### Get Programs (with token)
```bash
curl -X GET http://localhost:8000/api/v1/programs \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Submit Contact Form
```bash
curl -X POST http://localhost:8000/api/v1/contact/send \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "subject": "Inquiry",
    "message": "Hello..."
  }'
```

### Create Activity (admin only)
```bash
curl -X POST http://localhost:8000/api/v1/admin/activities \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "category_id": 1,
    "title": "Science Fair",
    "slug": "science-fair",
    "description": "Annual science exhibition",
    "activity_date": "2026-10-15",
    "location": "Main Hall",
    "is_published": true,
    "featured": true
  }'
```

---

## FEATURES

✅ Role-based access control (admin, teacher, user)
✅ Token-based authentication (Sanctum)
✅ Input validation with French error messages
✅ Pagination for list endpoints
✅ Soft deletes for data integrity
✅ Relationship eager loading
✅ View count tracking (activities)
✅ Search by category, level, type, specialization
