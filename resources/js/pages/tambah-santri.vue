<template>
  <div class="row">
    <div class="col-lg-12 m-auto">
      <card :title="$t('Tambah Data Santri')">
        <b-form @submit="onSubmit" @reset="onReset" v-if="yayasan.data">
          <b-form-group id="nama" label="Nama Lengkap:" label-for="nama">
            <b-form-input id="nama" v-model="form.nama" type="text" placeholder="Nama Lengkap" required></b-form-input>
          </b-form-group>

          <b-form-group id="tempat_lahir" label="Tempat Lahir" label-for="tempat_lahir">
            <b-form-input id="tempat_lahir" v-model="form.tempat_lahir" placeholder="Tempat Lahir" required></b-form-input>
          </b-form-group>
          <b-form-group id="tanggal_lahir" label="Tanggal Lahir" label-for="tanggal_lahir">
            <b-form-input id="tanggal_lahir" v-model="form.tanggal_lahir" placeholder="DD-MM-YYYY" required></b-form-input>
          </b-form-group>
          <b-form-group id="jenis_kelamin" label="Jenis Kelamin" label-for="jenis_kelamin">
            <b-form-select id="jenis_kelamin" v-model="form.jenis_kelamin" :options="jenis_kelamin" required></b-form-select>
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
    return { title: this.$t('Tambah Data Santri') }
  },
  async asyncData () {
    const { data: yayasan } = await axios.get('/api/referensi/yayasan')
    return {
      yayasan
    }
  },
  data() {
      return {
        form: {
          nama: '',
          tempat_lahir: '',
          tanggal_lahir: '',
          jenis_kelamin: null,
        },
        jenis_kelamin: [{ text: '== Pilih Jenis Kelamin ==', value: null }, {text: 'Laki-laki', value: 'L'}, {text: 'Perempuan', value: 'P'}],
      }
    },
    methods: {
      onSubmit(event) {
        event.preventDefault()
        //alert(JSON.stringify(this.form))
        axios.post('/api/referensi/santri', this.form).then((response) => {
          console.log(response);
        })
        this.$nextTick(() => {
          this.$router.push('santri')
        })
      },
      onReset(event) {
        event.preventDefault()
        // Reset our form values
        this.form.nama = ''
        this.form.tempat_lahir = ''
        this.form.jenis_kelamin = null
      }
    }
}
</script>
