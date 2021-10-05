<template>
  <div class="row">
    <div class="col-lg-12 m-auto">
      <card :title="$t('Data Yayasan')">
        <table class="table" v-if="yayasan.data">
          <tr>
            <td style="width:30%">Nama Yayasan/Pondok Pesantren</td>
            <td>: -</td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>: -</td>
          </tr>
          <tr>
            <td>Nama Ketua Yayasan/Pengasuh</td>
            <td>: -</td>
          </tr>
          <tr>
            <td>Pendamping</td>
            <td>: -</td>
          </tr>
          <tr>
            <td>Bendahara</td>
            <td>: -</td>
          </tr>
        </table>
        <b-alert show variant="danger">Data Yayasan tidak ditemukan. Silahkan tambah data Yayasan <b-button v-b-modal.modal-yayasan variant="success">disini</b-button></b-alert>
      </card>
    </div>
    <b-modal id="modal-yayasan" title="BootstrapVue">
      <p class="my-4">Hello from modal!</p>
    </b-modal>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
export default {
  middleware: 'auth',
  async asyncData () {
    console.log(this.user);
    const { data: yayasan } = await axios.get('/api/referensi/yayasan')
    return {
      yayasan
    }
  },
  metaInfo () {
    return { title: this.$t('Data Yayasan') }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
}
</script>
