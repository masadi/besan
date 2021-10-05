<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        {{ appName }}
      </router-link>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbar" class="collapse navbar-collapse">
        <ul v-if="user" class="navbar-nav">
          <!--locale-dropdown /-->
          <li class="nav-item">
            <router-link :to="{ name: 'home' }" class="nav-link">
              {{ $t('Yayasan') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'santri' }" class="nav-link">
              {{ $t('Santri') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'beasiswa' }" class="nav-link">
              {{ $t('Beasiswa') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'pembiayaan' }" class="nav-link">
              {{ $t('Pembiayaan') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'pengeluaran' }" class="nav-link">
              {{ $t('Pengeluaran') }}
            </router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Laporan
            </a>
            <div class="dropdown-menu">
              <router-link :to="{ name: 'laporan.belanja' }" class="dropdown-item">
                {{ $t('Laporan Belanja') }}
              </router-link>
              <router-link :to="{ name: 'laporan.terima' }" class="dropdown-item">
                {{ $t('Tanda Terima') }}
              </router-link>
              <router-link :to="{ name: 'laporan.kwitansi' }" class="dropdown-item">
                {{ $t('Kwitansi') }}
              </router-link>
            </div>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto">
          <!-- Authenticated -->
          <li v-if="user" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark"
               href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            >
              <img :src="user.photo_url" class="rounded-circle profile-photo me-1">
              {{ user.name }}
            </a>
            <div class="dropdown-menu">
              <router-link :to="{ name: 'settings.profile' }" class="dropdown-item ps-3">
                <fa icon="cog" fixed-width />
                {{ $t('settings') }}
              </router-link>

              <div class="dropdown-divider" />
              <a href="#" class="dropdown-item ps-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                {{ $t('logout') }}
              </a>
            </div>
          </li>
          <!-- Guest -->
          <template v-else>
            <li class="nav-item">
              <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                {{ $t('login') }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
                {{ $t('register') }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}

.container {
  max-width: 1100px;
}
</style>
