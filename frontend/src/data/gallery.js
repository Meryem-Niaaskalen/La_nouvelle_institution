const imageModules = import.meta.glob('../../public/images/**/*.{jpg,jpeg,png,webp,avif}', {
  eager: true,
  import: 'default',
})

const folderCategoryMap = {
  competitions: 'Événements',
  sports: 'Sports',
  'sorties scolaire': 'Activités',
  'activité para': 'Activités',
  'tournoi de foot': 'Sports',
}

const featuredHomeGalleryIds = [
  '/images/competitions/English comp.jpg',
  '/images/competitions/Tajwid 5.jpg',
  '/images/sports/sports 1.jpg',
  '/images/sorties scolaire/1.jpg',
  '/images/activité para/marche verte 2.jpg',
  '/images/sports/Sports 4.jpg',
]

const excludedPaths = ['logo-school', 'hero-16x9', 'school-flyer', 'school-poster', 'school-facade', 'school-front.jpg']

const toDisplayTitle = (fileName) => {
  const withoutExtension = fileName.replace(/\.(jpg|jpeg|png|webp|avif)$/i, '')
  return withoutExtension
    .replace(/[_-]+/g, ' ')
    .replace(/\s+/g, ' ')
    .trim()
    .replace(/\b\w/g, (char) => char.toUpperCase())
}

const galleryBaseItems = Object.entries(imageModules)
  .filter(([rawPath]) => /\.(jpg|jpeg|png|webp|avif)$/i.test(rawPath))
  .filter(([rawPath]) => !excludedPaths.some((segment) => rawPath.toLowerCase().includes(segment)))
  .map(([rawPath, image]) => {
    const normalizedPath = rawPath.replace(/\\/g, '/').replace('../../public/images/', '')
    const pathParts = normalizedPath.split('/')
    const fileName = pathParts[pathParts.length - 1]
    const folderName = pathParts.length > 1 ? pathParts[0] : ''
    const isRootPhoto = pathParts.length === 1

    return {
      id: normalizedPath,
      title: toDisplayTitle(fileName),
      date: '',
      image,
      category: isRootPhoto ? 'Autres' : folderCategoryMap[folderName] || 'Autres',
    }
  })

export const galleryItems = galleryBaseItems
  .filter((item) => item.category !== 'Autres')
  .sort((a, b) => a.title.localeCompare(b.title))
export const homepageGalleryItems = galleryItems.filter((item) => featuredHomeGalleryIds.includes(item.id))
export const galleryCategories = ['Tous', 'Événements', 'Sports', 'Activités']
