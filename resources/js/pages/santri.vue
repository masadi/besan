<template>
  <div class="row">
    <div class="col-lg-12 m-auto">
      <card :title="$t('Data Santri')" :button="true" :button_text="$t('Tambah Data')" :to="$t('tambah-santri')">
        <app-datatable :items="items" :fields="fields" :meta="meta" @per_page="handlePerPage" @pagination="handlePagination" @search="handleSearch" @sort="handleSort" />
        <!--b-table striped hover :items="items" :fields="fields" show-empty>
          <template #empty="scope">
            <p class="text-center">Tidak ada data untuk ditampilkan</p>
          </template>
          <template #emptyfiltered="scope">
            <p class="text-center">Tidak ada data untuk ditampilkan</p>
          </template>
        </b-table-->
      </card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import Datatable from '../components/datatables/Santri.vue' //IMPORT COMPONENT DATATABLENYA
export default {
  middleware: 'auth',
  components: {
    'app-datatable': Datatable //REGISTER COMPONENT DATATABLE
  },
  created() {
    //MAKA AKAN MENJALANKAN FUNGSI BERIKUT
    this.loadPostsData()
  },
  data() {
    return {
      fields: ['nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'aksi'],
      items: [],
      meta: [], //JUGA BERLAKU UNTUK META
      current_page: 1, //DEFAULT PAGE YANG AKTIF ADA PAGE 1
      per_page: 10, //DEFAULT LOAD PERPAGE ADALAH 10
      search: '',
      sortBy: 'created_at', //DEFAULT SORTNYA ADALAH CREATED_AT
      sortByDesc: true, //ASCEDING
    }
  },
  methods: {
    loadPostsData() {
      let current_page = this.current_page//this.search == '' ? this.current_page : 1
      //LAKUKAN REQUEST KE API UNTUK MENGAMBIL DATA POSTINGAN
      axios.get(`/api/referensi/santri`, {
        //KIRIMKAN PARAMETER BERUPA PAGE YANG SEDANG DILOAD, PENCARIAN, LOAD PERPAGE DAN SORTING.
        params: {
          page: current_page,
          per_page: this.per_page,
          q: this.search,
          sortby: this.sortBy,
          sortbydesc: this.sortByDesc ? 'DESC' : 'ASC'
        }
      }).then((response) => {
        let getData = response.data.data
        this.items = getData.data //MAKA ASSIGN DATA POSTINGAN KE DALAM VARIABLE ITEMS
        this.meta = {
          total: getData.total,
          current_page: getData.current_page,
          per_page: getData.per_page,
          from: getData.from,
          to: getData.to,
          isBusy: false,
        }
      })
    },
    handlePerPage(val) {
      this.per_page = val //SET PER_PAGE DENGAN VALUE YANG DIKIRIM DARI EMIT
      this.loadPostsData() //DAN REQUEST DATA BARU KE SERVER
    },
    //JIKA ADA EMIT PAGINATION YANG DIKIRIM, MAKA FUNGSI INI AKAN DIEKSEKUSI
    handlePagination(val) {
      this.current_page = val //SET CURRENT PAGE YANG AKTIF
      this.loadPostsData()
    },
    //JIKA ADA DATA PENCARIAN
    handleSearch(val) {
      this.search = val //SET VALUE PENCARIAN KE VARIABLE SEARCH
      this.loadPostsData() //REQUEST DATA BARU
    },
    //JIKA ADA EMIT SORT
    handleSort(val) {
      if (val.sortBy) {
        this.sortBy = val.sortBy
        this.sortByDesc = val.sortDesc
        this.loadPostsData() //DAN LOAD DATA BARU BERDASARKAN SORT
      }
    },
  },
  /*async asyncData () {
    const { data: data_santri } = await axios.get('/api/referensi/santri', {
      //KIRIMKAN PARAMETER BERUPA PAGE YANG SEDANG DILOAD, PENCARIAN, LOAD PERPAGE DAN SORTING.
      params: {
        page: this.current_page,
        per_page: this.per_page,
        q: this.search,
        sortby: this.sortBy,
        sortbydesc: this.sortByDesc ? 'DESC' : 'ASC'
        }
    })
    return {
      data_santri
    }
  },*/
  metaInfo () {
    return { title: this.$t('Data Santri') }
  },
}
</script>
