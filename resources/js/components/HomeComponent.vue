<template>
    <div class="main-container">
        <div class="row no-gutters">
            <div class="col-sm-4 services-list">
                <a @click.prevent="showKey = !showKey" href="#">
                    <div class="key w-100">
                        <h2>Key</h2>
                        <div class="hidden" v-if="showKey">
                            <h5>Categories</h5>
                            <div class="row align-items-center">
                                <div class="col-sm-1">
                                    <font-awesome-icon :icon="['fas', 'shopping-cart']" style="color: #28a228"/>
                                </div>
                                <div class="col-sm-4 px-4">
                                    Shop
                                </div>
                                <div class="col-sm-1">
                                    <font-awesome-icon :icon="['fas', 'clinic-medical']" style="color: #ff00ff"/>
                                </div>
                                <div class="col-sm-4 px-4">
                                    Health
                                </div>
                                
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-1">
                                    <font-awesome-icon :icon="['fas', 'prescription-bottle-alt']" style="color: #B8860B"/>
                                </div>
                                <div class="col-sm-4 px-4">
                                    Pharamist
                                </div>
                                <div class="col-sm-1">
                                    <font-awesome-icon :icon="['fas', 'user-md']" style="color: #3498DB"/>
                                </div>
                                <div class="col-sm-4 px-4">
                                    Doctors
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-1">
                                    <font-awesome-icon :icon="['fas', 'hospital-alt']" style="color: #FF0000"/>
                                </div>
                                <div class="col-sm-4 px-4">
                                    Hospital
                                </div>
                                <div class="col-sm-1">
                                    <font-awesome-icon :icon="['fas', 'hands-helping']" style="color: #D35400"/> 
                                </div>
                                <div class="col-sm-4 px-4">
                                    Community Worker
                                </div>
                            </div>
                            <h5>Services</h5>
                            <div class="row align-items-center">
                                <div class="col-sm-1">
                                    <font-awesome-icon :icon="['fas', 'home']" style="color: #f38d22"/>
                                </div>
                                <div class="col-sm-4 px-4">
                                    Home delivery
                                </div>
                                <div class="col-sm-1">
                                    <font-awesome-icon :icon="['fas', 'mouse']" style="color: #f38d22"/>
                                </div>
                                <div class="col-sm-4 px-4">
                                    Click and Collect
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-1">
                                    <font-awesome-icon :icon="['fas', 'drumstick-bite']" style="color: #f38d22"/>
                                </div>
                                <div class="col-sm-4 px-4">
                                    Take away
                                </div>
                                <div class="col-sm-1">
                                    <font-awesome-icon :icon="['fas', 'people-arrows']" style="color: #f38d22"/>
                                </div>
                                <div class="col-sm-4 px-4">
                                    Contact free
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-1">
                                    <font-awesome-icon :icon="['fas', 'phone']" style="color: #f38d22"/>
                                </div>
                                <div class="col-sm-4 px-4">
                                    Telephone call
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a @click.prevent="centreMap(location)" v-for="location in locations" :key="location.id" href="#" v-if='locations'>
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
               <div class="no-service" v-if="locations.length == 0">
                   no locations or service

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
                        @click="centreMap(m.location)"
                    />
                    <gmap-info-window
                        v-if="selectedLocation !== null"
                        :position="{ lat: Number(selectedLocation.latitude), lng: Number(selectedLocation.longitude) }"
                        :opened="infoBoxOpen"
                        @closeclick="infoBoxOpen = false;"
                    >
                        <div class="infoWindow" style="width: 400px;">
                            <div class="col-sm-9 details">
                                <h2 id="infoWindow-location">{{ selectedLocation.name }}</h2>
                                <p>{{selectedLocation.description}}</p>
                                <h5>Contact Details</h5>
                                <p class="phone">Phone Number: {{selectedLocation.phone}}</p>
                                <p v-if="selectedLocation.email">Email: <a :href="'mailto:' + selectedLocation.email">{{selectedLocation.email}}</a></p>
                                <h5>Opening hours</h5>
                                <table>
                                    <tr>
                                        <th>
                                        </th>
                                        <th>
                                            Open
                                        </th>
                                        <th>
                                            Close
                                        </th>
                                    </tr>
                                    <tr v-for="day in selectedLocation.opening_times" :key="day.id">
                                        <td>
                                            {{day.day}}
                                        </td>
                                        <td>
                                            {{day.open_time || "Closed"}}
                                        </td>
                                        <td>
                                            {{day.close_time || "Closed"}}
                                        </td>
                                    </tr>
                                </table>
                                <div v-if="selectedLocation.services.length" class="services">
                                    <h5>Services Offered</h5>
                                    <div class="icon-row">
                                        <div class="icon" v-for="service in selectedLocation.services" :key="service.id">
                                            <font-awesome-icon :icon="['fas', 'home']" v-if="service.name == 'Home delivery'" style="color: #f38d22"/>
                                            <font-awesome-icon :icon="['fas', 'mouse']" v-if="service.name == 'Click and Collect'" style="color: #f38d22"/>
                                            <font-awesome-icon :icon="['fas', 'drumstick-bite']" v-if="service.name == 'Take away'" style="color: #f38d22"/>
                                            <font-awesome-icon :icon="['fas', 'people-arrows']" v-if="service.name == 'Contact Free'" style="color: #f38d22"/>
                                            <font-awesome-icon :icon="['fas', 'phone']" v-if="service.name == 'Telephone Call'" style="color: #f38d22"/>
                                        </div>
                                    </div>
                                </div>
                                <button @click="closeInfoWindow();">Close</button>
                            </div>
                            <div class="col-sm-3 logo">
                                <img :src="selectedLocation.logo" :alt="selectedLocation.name" />
                                <div class="icon" v-for="category in selectedLocation.categories" :key="category.id">
                                    <font-awesome-icon :icon="['fas', 'shopping-cart']" v-if="category.name == 'Food'" style="color: #28a228"/>
                                    <font-awesome-icon :icon="['fas', 'clinic-medical']" v-if="category.name == 'Health'" style="color: #ff00ff"/>
                                    <font-awesome-icon :icon="['fas', 'prescription-bottle-alt']" v-if="category.name == 'Pharamist'" style="color: #B8860B"/>
                                    <font-awesome-icon :icon="['fas', 'user-md']" v-if="category.name == 'Doctors'" style="color: #3498DB"/>
                                    <font-awesome-icon :icon="['fas', 'hospital-alt']" v-if="category.name == 'Hospital'" style="color: #FF0000"/>
                                    <font-awesome-icon :icon="['fas', 'hands-helping']" v-if="category.name == 'Community Worker'" style="color: #D35400"/>
                                </div>
                            </div>
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
                showKey: false
            }
        },
        
        async created () {
            await axios
                .get('/locations/all')
                .then(response => (
                    this.locations = response.data.locations
                    )
                );


            this.getMarkers();

        },

        methods: {
            getMarkers() {
                const result = this.locations.map((item) => {
                    return {
                        position: {
                            lat: Number(item.latitude),
                            lng: Number(item.longitude)
                        },
                        location: item
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
            },
            openingHours(string) {
                const array = JSON.stringify(selectedLocation.opening_hours);
                console.log(array);
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