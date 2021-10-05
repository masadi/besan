<template>
  <div class="row">
    <div class="col-lg-12 m-auto">
      <card :title="$t('Data Sumber Dana')">
        {{ $t('you_are_logged_in') }}
        {{user}}
        {{projects}}
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
    const { data: projects } = await axios.get('/api/projects/')
    return {
      projects
    }
  },
  metaInfo () {
    return { title: this.$t('Sumber Dana') }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
}
</script>
