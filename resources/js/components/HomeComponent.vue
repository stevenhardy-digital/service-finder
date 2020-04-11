<template>
    <div class="main-container">
        <div class="row no-gutters">
            <div class="col-sm-4 services-list">
               <div class="location" v-for="location in locations" :key="location.id" @click="centreMap(location)">
                   <div class="logo">
                       <img :src="location.logo" :alt="location.name" />
                   </div>
                   <div class="details">
                        <h5>{{location.name}}</h5>
                        <p>{{location.location}}</p>
                        <p>{{location.description}}</p>
                   </div>
               </div>
            </div>
            <div class="col-sm-8 map">
               <GmapMap
                    :center="center"
                    :zoom="13"
                    map-type-id="terrain"
                    class="google-map"
                    >
                    <GmapMarker
                        :key="index"
                        v-for="(m, index) in markers"
                        :position="m.position"
                        :clickable="true"
                        :draggable="true"
                        @click="center=m.position"
                    />
                </GmapMap>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                locations: [],
                markers: [],
                lines: [],
                center: {lat:51.880087, lng:0.550927}
            }
        },
        
        async created () {
            await axios
                .get('http://service.test/locations/all')
                .then(response => (
                    this.locations = response.data.locations
                    
                    ));


            this.getMarkers();

        },

        methods: {
            getMarkers() {
                const result = this.locations.map((item) => {
                    return {
                        position: {
                            lat: Number(item.latitude),
                            lng: Number(item.longitude)
                        }
                    };
                });

                this.markers = result;
            },

            centreMap(location) {
                const result =  {
                        lat: Number(location.latitude),
                        lng: Number(location.longitude)
                };

                this.center = result;
            }
        },
    }
</script>

<style scoped lang='scss'>
  .google-map {
    display: flex;
    justify-content: center;
    align-items: center;
    &__map {
      height: 460px;
      width: 100%;
    }
    &__placeholder {
      height: 460px;
      width: 100%;
    }
  }
</style>