<template>
  <div class="container">
    <div class="container-title">
      <font-awesome-icon :icon="['fas', 'angle-left']" size="2x" :style="{ color: 'white' }" />
      <h2>Voitures</h2>
    </div>
    <div class="tableContainer">
      <div class="table-heading">
        <h2>Liste des voitures</h2>
        <div class="actions">
          <font-awesome-icon  :icon="['fas', 'circle-plus']" :style="{ color: '#00FC80' }" size="2x" />
          <font-awesome-icon :icon="['fas', 'circle-minus']" :style="{ color: '#A1136B' }" size="2x" />
        </div>
      </div>
      <ul class="responsive-table">
        <li class="table-row" v-for="voiture in voitures" :key="voiture.id" @click="openModal(voiture)">
          <div class="col col-4" data-label="Plaque d’immatriculation">{{ voiture.numero_immatriculation }}</div>
          <div class="col col-2" data-label="Date d'achat">{{ voiture.date_achat.split('T')[0] }}</div>
          <div class="col col-3" data-label="Usage">{{ voiture.vehicleUsage }}</div>
        </li>
      </ul>
    </div>
    <div v-if="showModal" class="modal-overlay">
      <div class="modal-content">
        <font-awesome-icon @click="closeModal" size="2x" :icon="['fas', 'xmark']" :style="{ color: 'white', cursor: 'pointer' }" />
        <h3> Détails du Voiture</h3>
 
        <VoitureForm v-if="selectedVoiture" :voiture="selectedVoiture" @submit="handleSubmit" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import VoitureForm from '@/components/VoitureForm.vue';

const showModal = ref(false);
const selectedVoiture = ref(null);
const voitures = ref([]);

const fetchVoitures = async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/voitures');
    voitures.value = response.data.member;
  } catch (error) {
    console.error('Error fetching voitures:', error);
  }
};

onMounted(() => {
  fetchVoitures();
});

const openModal = (voiture = null) => {
  selectedVoiture.value = voiture; 
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedVoiture.value = null;
};

const handleSubmit = (formData) => {

console.log('Form submitted:', formData);
closeModal(); 
fetchVoitures()
};
</script>

<style>
.container {
  padding: 34px;
}

.container-title {
  display: flex;
  flex-direction: row;
  justify-content: start;
  align-items: center;
}

h2 {
  font-size: 26px;
  margin: 20px 10px;
  text-align: center;
  color: #ffffff;
}

.tableContainer {
  background: #302C55;
  padding: 25px 34px;
  border-radius: 10px;
}

.table-heading {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  margin-right: 10px;
  margin-bottom: 30px;
}

.actions {
  display: flex;
  gap: 20px;
}

.responsive-table li {
  border-radius: 10px;
  padding: 25px 30px;
  display: flex;
  justify-content: space-between;
  margin-bottom: 25px;
}

.responsive-table .table-row {
  background-color: var(--dark);
  color: #ffffff;
  box-shadow: 0px 0px 9px 0px rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

.responsive-table .col-2 {
  flex-basis: 40%;
}

.responsive-table .col-3 {
  flex-basis: 25%;
}

.responsive-table .col-4 {
  flex-basis: 25%;
}

@media all and (max-width: 767px) {
  .responsive-table .table-header {
    display: none;
  }

  .responsive-table li {
    display: block;
  }

  .responsive-table .col {
    flex-basis: 100%;
    display: flex;
    padding: 10px 0;
  }

  .responsive-table .col:before {
    color: #6C7A89;
    padding-right: 10px;
    content: attr(data-label);
    flex-basis: 50%;
    text-align: right;
  }
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: #302C55;
  padding: 20px;
  border-radius: 8px;
  width: 50%;
  max-width: 100%;
}

.modal-content h3 {
  padding: 15px;
  color: white;
  text-align: center;
}

.modal-content form div {
  margin-bottom: 10px;
}

.modal-content button {
  margin-top: 10px;
}
</style>
