<template>
  <div class="row">
    <div class="col-lg-12 m-auto">
      <card :title="$t('Tambah Data Santri')">
        <b-alert show variant="danger" v-if="error">{{error}}</b-alert>
        <b-form @submit="onSubmit" @reset="onReset" v-if="santri.data">
          <b-form-group id="santri_id" label="Nama Santri" label-for="santri_id">
            <b-form-select id="santri_id" v-model="form.santri_id" :options="santri.data" required></b-form-select>
          </b-form-group>
          <b-form-group id="tahun" label="Tahun Anggaran" label-for="tahun">
            <b-form-input id="tahun" v-model="form.tahun" type="text" placeholder="YYYY" required></b-form-input>
          </b-form-group>

          <b-form-group id="jumlah" label="Jumlah (Rp)" label-for="jumlah">
            <b-form-input id="jumlah" v-model="form.jumlah" placeholder="Jumlah (Rp)" required></b-form-input>
          </b-form-group>
          <b-form-group class="mt-3">
            <b-button type="submit" variant="primary">Simpan</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
          </b-form-group>
        </b-form>
      </card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: this.$t('Tambah Data Beasiswa') }
  },
  async asyncData () {
    const { data: santri } = await axios.get('/api/referensi/santri-select')
    return {
      santri
    }
  },
  data() {
      return {
        error: '',
        form: {
          santri_id: null,
          tahun: '',
          jumlah: '',
        },
      }
    },
    methods: {
      onSubmit(event) {
        event.preventDefault()
        //alert(JSON.stringify(this.form))
        axios.post('/api/referensi/beasiswa', this.form).then((response) => {
          if(response.data.status === 'failed'){
            console.log('failed');
            this.error = response.data.message
            return false
          } else {
            console.log('sukses');
            this.error = ''
            this.$nextTick(() => {
              this.$router.push('beasiswa')
            })
          }
        })
      },
      onReset(event) {
        event.preventDefault()
        // Reset our form values
        this.form.santri_id = null
        this.form.tahun = ''
        this.form.jumlah = ''
      }
    }
}
</script>
