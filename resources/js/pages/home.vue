<template>
  <div class="row">
    <div class="col-lg-12 m-auto">
      <card :title="$t('Data Yayasan')">
        <table class="table" v-if="yayasan.data">
          <tr>
            <td style="width:30%">Nama Yayasan/Pondok Pesantren</td>
            <td>: {{this.yayasan.data.nama}}</td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>: {{this.yayasan.data.alamat}}</td>
          </tr>
          <tr>
            <td>Nama Ketua Yayasan/Pengasuh</td>
            <td>: {{this.yayasan.data.ketua}}</td>
          </tr>
          <tr>
            <td>Pendamping</td>
            <td>: {{this.yayasan.data.pendamping}}</td>
          </tr>
          <tr>
            <td>Bendahara</td>
            <td>: {{this.yayasan.data.bendahara}}</td>
          </tr>
        </table>
        <b-button v-if="yayasan.data" v-b-modal.modal-yayasan variant="success">Edit Data</b-button>
        <b-alert show variant="danger" v-if="!yayasan.data">Data Yayasan tidak ditemukan. Silahkan tambah data Yayasan <b-button v-b-modal.modal-yayasan variant="success">disini</b-button></b-alert>
      </card>
    </div>
    <b-modal id="modal-yayasan" title="Tambah/Edit Data Yayasan" size="lg" ref="modal-yayasan" @show="resetModal" @hidden="resetModal" @ok="handleOk">
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <input type="hidden" v-model="yayasan_id">
        <b-form-group label="Nama Yayasan/Pondok Pesantren" label-for="nama" invalid-feedback="Nama Yayasan/Pondok Pesantren tidak boleh kosong" :state="namaState">
          <b-form-input id="nama" v-model="nama" :state="namaState" required></b-form-input>
        </b-form-group>
        <b-form-group label="Alamat" label-for="alamat" invalid-feedback="Alamat" :state="alamatState">
          <b-form-input id="alamat" v-model="alamat" :state="alamatState" required></b-form-input>
        </b-form-group>
        <b-form-group label="Ketua Yayasan/Pengasuh Pesantren" label-for="ketua" invalid-feedback="Ketua Yayasan/Pengasuh Pesantren tidak boleh kosong" :state="ketuaState">
          <b-form-input id="ketua" v-model="ketua" :state="ketuaState" required></b-form-input>
        </b-form-group>
        <b-form-group label="Nama Pendamping" label-for="pendamping" invalid-feedback="Nama Pendamping tidak boleh kosong" :state="pendampingState">
          <b-form-input id="pendamping" v-model="pendamping" :state="pendampingState" required></b-form-input>
        </b-form-group>
        <b-form-group label="Nama Bendahara" label-for="bendahara" invalid-feedback="Nama Bendahara tidak boleh kosong" :state="bendaharaState">
          <b-form-input id="bendahara" v-model="bendahara" :state="bendaharaState" required></b-form-input>
        </b-form-group>
      </form>
    </b-modal>
  </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'
import { mapGetters } from 'vuex'
export default {
  middleware: 'auth',
  data() {
    return {
      yayasan_id: '',
      nama: '',
      namaState: null,
      alamat: '',
      alamatState: null,
      ketua: '',
      ketuaState: null,
      pendamping: '',
      pendampingState: null,
      bendahara: '',
      bendaharaState: null,
    }
  },
  async asyncData () {
    const { data: yayasan } = await axios.get('/api/referensi/yayasan')
    return {
      yayasan
    }
  },
  metaInfo () {
    return { title: this.$t('Data Yayasan') }
  },
  methods: {
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity()
      this.namaState = valid
      this.alamatState = valid
      this.ketuaState = valid
      this.pendampingState = valid
      this.bendaharaState = valid
      return valid
    },
    resetModal() {
      if(this.yayasan.data){
        this.yayasan_id = this.yayasan.data.id
        this.nama = this.yayasan.data.nama
        this.namaState = null
        this.alamat = this.yayasan.data.alamat
        this.alamatState = null
        this.ketua = this.yayasan.data.ketua
        this.ketuaState = null
        this.pendamping = this.yayasan.data.pendamping
        this.pendampingState = null
        this.bendahara = this.yayasan.data.bendahara
        this.bendaharaState = null
      } else {
        this.yayasan_id = ''
        this.nama = ''
        this.namaState = null
        this.alamat = ''
        this.alamatState = null
        this.ketua = ''
        this.ketuaState = null
        this.pendamping = ''
        this.pendampingState = null
        this.bendahara = ''
        this.bendaharaState = null
      }
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault()
      // Trigger submit handler
      this.handleSubmit()
    },
    handleSubmit() {
      this.$loading(true)
      // Exit when the form isn't valid
      if (!this.checkFormValidity()) {
        return
      }
      axios.post('/api/referensi/yayasan',{
        yayasan_id: this.yayasan_id,
        nama: this.nama,
        alamat: this.alamat,
        ketua: this.ketua,
        pendamping: this.pendamping,
        bendahara: this.bendahara,
      }).then((response) => {
        axios.get('/api/referensi/yayasan').then((response) => {
          let getData = response.data
          this.yayasan = getData
          this.$nextTick(() => {
            this.$bvModal.hide('modal-yayasan')
            this.$loading(false)
          })
        });
      })
    }
  }
}
</script>
