<script >
import { TailwindPagination } from 'laravel-vue-pagination';
import AppLayout from "@/Layouts/AppLayout.vue";
import PaginationVue from '../Components/Pagination.vue';
import axios from 'axios';

export default{
  layout:AppLayout,
  props:['records'],
  components:{PaginationVue,TailwindPagination},
  data(){
    return{
      myRecords:this.records

    }
  },
  methods:{
    getRecords(page=1){
      axios.get(`/dashboard?page=${page}`).then((response)=>{
        this.myRecords=response.data
      })

    },
    totalPrice(wheight, unitPrice){
      return parseFloat(wheight)*parseFloat(unitPrice)

    }
  }

}
</script>

<template>



    <div class="py-12 px-2">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="overflow-x-auto">
            <table class="table w-full  table-compact">
              <!-- head -->
              <thead>
                <tr>
                  <th></th>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>Phone number</th>
                  <th>Gender</th>
                  <th>Age</th>
                  <th>region</th>
                  <th>district</th>
                  <th>ward</th>
                  <th>Sub village</th>
                  <th>AMCOS</th>
                  <th>AMCOS physical location</th>
                  <th>Collector name</th>
                  <th>Collector phone number</th>
                  <th>Wheight</th>
                  <th>Price per KG</th>
                  <th>Total price</th>


                </tr>
              </thead>
              <tbody>
                <tr v-for="item,index in myRecords.data" :key="index">
                  <th v-text="item.id"></th>
                  <th v-text="item.firstname"></th>
                  <td v-text="item.lastname"></td>
                  <td v-text="item.phone_number"></td>
                  <td v-text="item.gender"></td>
                  <td v-text="item.age"></td>
                  <td v-text="item.region"></td>
                  <td v-text="item.district"></td>
                  <td v-text="item.ward"></td>
                  <td v-text="item.sub_village"></td>
                  <td v-text="item.amcos"></td>
                  <td v-text="item.amcos_physical_location"></td>
                  <td v-text="item.collector_name"></td>
                  <td v-text="item.collector_phone_number"></td>
                  <td v-text="item.wheight"></td>
                  <td v-text="item.price_per_kg"></td>
                  <td v-text="totalPrice(item.wheight,item.price_per_kg)"></td>

                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <TailwindPagination
        :data="myRecords"
        @pagination-change-page="getRecords" class="mt-6 max-w-7xl mx-auto sm:px-6 lg:px-16" 
    />
      <!-- <PaginationVue :links="records.links"></PaginationVue> -->
    </div>
    

</template>
