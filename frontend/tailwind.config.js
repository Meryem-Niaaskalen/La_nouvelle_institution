/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js,jsx,ts,tsx}'],
  theme: {
    extend: {
      colors: {
        // School Brand Colors
        primary: {
          50: '#FFF3E0',
          100: '#FFE0B2',
          200: '#FFCC80',
          300: '#FFB74D',
          400: '#FFA726',
          500: '#F57C00', // Main Orange
          600: '#FB8C00',
          700: '#E65100',
          800: '#D84315',
          900: '#BF360C',
        },
        gray: {
          50: '#FAFAFA',
          100: '#F5F5F5',
          200: '#EEEEEE',
          300: '#E0E0E0',
          400: '#BDBDBD',
          500: '#9E9E9E',
          600: '#757575',
          700: '#616161',
          800: '#424242', // Main Dark Gray
          900: '#212121',
        },
        // Semantic colors
        success: '#4CAF50',
        warning: '#FFC107',
        error: '#F44336',
        info: '#2196F3',
      },
      fontFamily: {
        sans: ['Poppins', 'Inter', 'system-ui', 'sans-serif'],
        heading: ['Poppins', 'Inter', 'system-ui', 'sans-serif'],
        mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'monospace'],
      },
      fontSize: {
        // Headings
        'h1': ['56px', { lineHeight: '1.2', fontWeight: '700' }],
        'h2': ['40px', { lineHeight: '1.3', fontWeight: '600' }],
        'h3': ['32px', { lineHeight: '1.4', fontWeight: '600' }],
        'h4': ['24px', { lineHeight: '1.4', fontWeight: '600' }],
        'h5': ['20px', { lineHeight: '1.5', fontWeight: '600' }],
        'h6': ['16px', { lineHeight: '1.5', fontWeight: '600' }],
        // Body
        'body-lg': ['18px', { lineHeight: '1.6' }],
        'body-base': ['16px', { lineHeight: '1.6' }],
        'body-sm': ['14px', { lineHeight: '1.6' }],
        'body-xs': ['12px', { lineHeight: '1.5' }],
      },
      spacing: {
        'section': '100px',
        'section-sm': '60px',
      },
      borderRadius: {
        'sm': '4px',
        'md': '8px',
        'lg': '12px',
        'xl': '16px',
      },
      boxShadow: {
        'soft': '0 2px 8px rgba(0, 0, 0, 0.08)',
        'medium': '0 4px 16px rgba(0, 0, 0, 0.12)',
        'large': '0 8px 24px rgba(0, 0, 0, 0.15)',
        'hover': '0 12px 32px rgba(0, 0, 0, 0.2)',
      },
      animation: {
        'fade-in': 'fadeIn 0.6s ease-out',
        'slide-up': 'slideUp 0.6s ease-out',
        'slide-down': 'slideDown 0.6s ease-out',
        'scale-in': 'scaleIn 0.6s ease-out',
        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        slideDown: {
          '0%': { opacity: '0', transform: 'translateY(-20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        scaleIn: {
          '0%': { opacity: '0', transform: 'scale(0.95)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
      },
      transitionDuration: {
        'fast': '150ms',
        'normal': '300ms',
        'slow': '500ms',
      },
    },
  },
  plugins: [],
}
