import client from './client'

export const getActualities = async () => {
	const { data } = await client.get('/actualities')
	return Array.isArray(data?.data) ? data.data : []
}

export const getPrograms = () => client.get('/programs')
export const getProgramById = (id) => client.get(`/programs/${id}`)

export const getAdminPrograms = () => client.get('/admin/programs')
export const createAdminProgram = (data) => client.post('/admin/programs', data)
export const updateAdminProgram = (id, data) => client.put(`/admin/programs/${id}`, data)
export const deleteAdminProgram = (id) => client.delete(`/admin/programs/${id}`)

export const getTeachers = () => client.get('/teachers')
export const getTeacherById = (id) => client.get(`/teachers/${id}`)

export const getActivities = (params = {}) => client.get('/activities', { params })
export const getFeaturedActivities = () => client.get('/activities/featured')
export const getActivitiesByCategory = (slug) => client.get(`/activities/category/${slug}`)
export const getActivityById = (id) => client.get(`/activities/${id}`)

export const getGalleryCategories = () => client.get('/gallery/categories')
export const getGalleryImages = (categoryId) => client.get(`/gallery/categories/${categoryId}/images`)

export const getTestimonials = () => client.get('/testimonials')

export const sendContactMessage = (data) => client.post('/contact/send', data)

export const getPublicSettings = () => client.get('/settings/public')

export const updateSetting = (key, data) => client.put(`/admin/settings/${key}`, data)
