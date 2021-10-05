<template>
  <div class="row">
    <div class="col-lg-12 m-auto">
      <card :title="$t('Laporan Belanja')">
        {{ $t('you_are_logged_in') }}
        {{user}}
      </card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
export default {
  middleware: 'auth',
  async asyncData () {
    console.log(this.user);
    const { data: projects } = await axios.get('/api/projects/')
    return {
      projects
    }
  },
  metaInfo () {
    return { title: this.$t('Laporan Belanja') }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
}
</script>
