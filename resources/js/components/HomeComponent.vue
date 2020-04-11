<template>
    <div class="main-container">
        <div class="row no-gutters">
            <div class="col-sm-4 services-list">
                <a @click.prevent="centreMap(location)" v-for="location in locations" :key="location.id" href="#">
                    <div class="location">
                        <div class="logo">
                            <img :src="location.logo" :alt="location.name" />
                        </div>
                        <div class="details">
                                <h5>{{location.name}}</h5>
                                <p>{{location.location}}</p>
                                <p>{{location.description}}</p>
                        </div>
                        <div class="icon" v-for="category in location.categories" :key="category.id">
                                <font-awesome-icon :icon="['fas', 'shopping-cart']" v-if="category.name == 'Food'" style="color: #28a228"/>
                                <font-awesome-icon :icon="['fas', 'clinic-medical']" v-if="category.name == 'Health'" style="color: #ff00ff"/>
                                <font-awesome-icon :icon="['fas', 'prescription-bottle-alt']" v-if="category.name == 'Pharamist'" style="color: #B8860B"/>
                                <font-awesome-icon :icon="['fas', 'user-md']" v-if="category.name == 'Doctors'" style="color: #3498DB"/>
                                <font-awesome-icon :icon="['fas', 'hospital-alt']" v-if="category.name == 'Hospital'" style="color: #FF0000"/>
                                <font-awesome-icon :icon="['fas', 'hands-helping']" v-if="category.name == 'Community Worker'" style="color: #D35400"/>
                        </div>
                    </div>
               </a>
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
                    <gmap-info-window
                        v-if="selectedLocation !== null"
                        :position="{ lat: Number(selectedLocation.latitude), lng: Number(selectedLocation.longitude) }"
                        :opened="infoBoxOpen"
                        @closeclick="infoBoxOpen = false;"
                    >
                        <div class="infoWindow" style="width: 300px;">
                        <h2 id="infoWindow-location">{{ selectedLocation.name }}</h2>
                        <p>{{selectedLocation.description}}</p>
                        <button @click="closeInfoWindow();">Close</button>
                        </div>
                    </gmap-info-window>
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
                center: {lat:51.880087, lng:0.550927},
                selectedLocation: null,
                infoBoxOpen: false,
            }
        },
        
        async created () {
            await axios
                .get('/locations/all')
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
                this.selectedLocation = location;
                this.infoBoxOpen = true;
            },
            closeInfoWindow() {
                this.infoBoxOpen = false;
                this.selectedLocation = null;
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