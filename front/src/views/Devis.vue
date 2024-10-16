<template>
  <div class="container">
    <div class="container-title">

      <font-awesome-icon :icon="['fas', 'angle-left']" size="2x" :style="{ color: 'white' }" />
      <h2>Devis</h2>
    </div>
    <div class="tableContainer">
      <div class="table-heading">
        <h2>Liste des Devis</h2>
        <div class="actions">

          <font-awesome-icon :icon="['fas', 'circle-plus']" :style="{ color: '#00FC80' }" size="2x"
            @click="openModal" />
          <font-awesome-icon :icon="['fas', 'circle-minus']" :style="{ color: '#A1136B' }" size="2x" />
        </div>
      </div>
      <ul class="responsive-table">
        <li class="table-row" v-for="devis in devisList" :key="devis.id">
         <strong>  <div class="col col-1" data-label="Type">Auto</div></strong>
          <div class="col col-2" data-label="Client">
            {{ devis.clientInfo.prenom }} {{ devis.clientInfo.nom }}
          </div>
          <div class="col col-3" data-label="Prix">
            {{ devis.prix }} € ({{ devis.frequence_prix }})
          </div>
        </li>
      </ul>

    </div>
    <div v-if="showModal" class="modal-overlay">

      <div class="modal-content">
        <font-awesome-icon @click="closeModal" size="2x" :icon="['fas', 'xmark']"
          :style="{ color: 'white', cursor: 'pointer' }" />
        <h3>Détails du devis</h3>

        <DevisForm @submit="handleSubmit" />

      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios'; 
const devisList = ref([]);
const fetchDevis = async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/devis');
    const devisData = response.data.member;
    const devisWithDetails = await Promise.all(
      devisData.map(async (devis) => {
        const clientResponse = await axios.get(`http://127.0.0.1:8000${devis.client}`);
        devis.clientInfo = clientResponse.data; 
        const vehicleDetails = await Promise.all(
          devis.voitures.map(async (voitureUrl) => {
            const vehicleResponse = await axios.get(`http://127.0.0.1:8000${voitureUrl}`);
            return vehicleResponse.data; 
          })
        );

        devis.vehicles = vehicleDetails; 
        return devis;
      })
    );

    devisList.value = devisWithDetails;
  } catch (error) {
    console.error('Error fetching devis, clients, or vehicles:', error);
  }
};

onMounted(() => {
  fetchDevis();
});
</script>

<style>
.container {
  width: 100%;
  margin-left: 300px;
}
</style>