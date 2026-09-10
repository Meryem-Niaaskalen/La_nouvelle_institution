import client from './client'

const normalizeMessage = (message) => ({
  ...message,
  is_read: Boolean(message.is_read ?? (message.status === 'read' || message.status === 'responded')),
  is_important: Boolean(message.is_important),
})

export const getAdminContactMessages = async () => {
  const { data } = await client.get('/admin/contact/messages')
  const payload = Array.isArray(data) ? data : data?.data ?? []
  return payload.map(normalizeMessage)
}

export const getAdminDashboard = async () => {
  const { data } = await client.get('/admin/dashboard')
  return data?.data ?? {}
}

export const getAdminSettings = async () => {
  const { data } = await client.get('/admin/settings')
  return data?.data ?? []
}

export const updateAdminContactMessage = async (id, updates) => {
  try {
    const { data } = await client.put(`/admin/contact/messages/${id}`, updates)
    return normalizeMessage(data?.data ?? data)
  } catch (error) {
    console.warn('Fallback update for admin message', error)
    return { id, ...updates }
  }
}

export const deleteAdminContactMessage = async (id) => {
  try {
    await client.delete(`/admin/contact/messages/${id}`)
    return true
  } catch (error) {
    console.warn('Fallback delete for admin message', error)
    return true
  }
}

export const getAdminGalleryCategories = async () => {
  try {
    const { data } = await client.get('/admin/gallery/categories')
    return Array.isArray(data?.data) ? data.data : Array.isArray(data) ? data : []
  } catch (error) {
    console.warn('Fallback gallery categories', error)
    return []
  }
}

export const createAdminGalleryCategory = async (payload) => {
  const { data } = await client.post('/admin/gallery/categories', payload)
  return data?.data ?? data
}

export const updateAdminGalleryCategory = async (id, payload) => {
  const { data } = await client.put(`/admin/gallery/categories/${id}`, payload)
  return data?.data ?? data
}

export const deleteAdminGalleryCategory = async (id) => {
  const { data } = await client.delete(`/admin/gallery/categories/${id}`)
  return data?.data ?? {}
}

export const createAdminGalleryImage = async (payload) => {
  const { data } = await client.post('/admin/gallery/images', payload)
  return data?.data ?? data
}

export const updateAdminGalleryImage = async (id, payload) => {
  const { data } = await client.put(`/admin/gallery/images/${id}`, payload)
  return data?.data ?? data
}

export const deleteAdminGalleryImage = async (id) => {
  const { data } = await client.delete(`/admin/gallery/images/${id}`)
  return data?.data ?? {}
}

export const getAdminActualities = async () => {
  const { data } = await client.get('/admin/actualities')
  return Array.isArray(data?.data) ? data.data : []
}

export const createAdminActuality = async (payload) => {
  const { data } = await client.post('/admin/actualities', payload)
  return data?.data ?? data
}

export const updateAdminActuality = async (id, payload) => {
  const { data } = await client.post(`/admin/actualities/${id}`, payload)
  return data?.data ?? data
}

export const deleteAdminActuality = async (id) => {
  const { data } = await client.delete(`/admin/actualities/${id}`)
  return data?.data ?? {}
}
