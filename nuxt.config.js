const path = require('path')

export default {
  mode: 'universal',
  /*
  ** Headers of the page
  */
  head: {
    title: process.env.npm_package_name || '',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: process.env.npm_package_description || '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ],
    script: [
      {src: 'https://js.stripe.com/v3/'}
    ]
  },
  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#ffda29', height: '5px' },
  /*
  ** Global CSS
  */
  css: [
    './assets/tailwind.css',
  ],
  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    //{url: 'https://js.stripe.com/v3/', mode: 'client'},
  ],
  /*
  ** Nuxt.js dev-modules
  */
  buildModules: [
    '@nuxtjs/fontawesome',
  ],

  fontawesome: {
    icons: {
      solid: ['faBars']
    }
  },
  /*
  ** Nuxt.js modules
  */
  modules: [
    // Doc: https://bootstrap-vue.js.org
    'bootstrap-vue/nuxt',
    // Doc: https://axios.nuxtjs.org/usage
    '@nuxtjs/axios',
    '@nuxtjs/auth',
    '@nuxtjs/pwa',
    // Doc: https://github.com/nuxt-community/dotenv-module
    '@nuxtjs/dotenv',
    'nuxt-purgecss',
  ],
  purgeCSS: {
    mode: 'postcss',
    enabled: (process.env.NODE_ENV === 'production')
  },
  /*
  ** Axios module configuration
  ** See https://axios.nuxtjs.org/options
  */
  axios: {
    baseURL: 'http://localhost:8000/api'
  },/*
  router: {
    middleware: ['auth']
  },*/
  /**
   *  Auth module configuration
   */
  auth: {
    redirect: {
      logout: '/login',
      callback: '/login'
    },
    strategies: {
      local: {
        endpoints: {
          login: {url: 'auth/login', method: 'post', propertyName: 'access_token'},
          user: {url: 'auth/me', method: 'get', propertyName: false},
          logout: {url: 'auth/logout', method: 'post'},
        },
        token: {
          maxAge: 5 * 60
        },
        refreshToken: {
          maxAge: 20160 * 60
        }
      },
    }
  },
  /*
  ** Build configuration
  */
  build: {
    postcss: {
      plugins: {
        'postcss-import': {},
        tailwindcss: path.resolve(__dirname, 'tailwind.config.js'),
        'postcss-nested': {}
      }
    },
    preset: {
      stage: 1
    },
    extend (config, ctx) {
    }
  }
}


