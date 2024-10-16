<template>
  <div class="container">
    <div class="container-title">
      <font-awesome-icon :icon="['fas', 'angle-left']" size="2x" :style="{ color: 'white' }" />
      <h2>Clients</h2>
    </div>
    <div class="tableContainer">
      <div class="table-heading">
        <h2>List des clients</h2>
        <div class="actions">
          <font-awesome-icon :icon="['fas', 'circle-plus']" :style="{ color: '#00FC80' }" size="2x" />
          <font-awesome-icon :icon="['fas', 'circle-minus']" :style="{ color: '#A1136B' }" size="2x" />
        </div>
      </div>
      <ul class="responsive-table">
        <li class="table-row" v-for="client in clients" :key="client.id" @click="openModal(client)">
          <div class="col col-4" data-label="Status">{{ client.est_personne ? 'Particulier' : 'Personne morale' }}</div>
          <div class="col col-2" data-label="Nom">{{ client.nom }} {{ client.prenom }}</div>
          <div class="col col-3" data-label="Date de naissance">{{ client.date_naissance.split('T')[0] }}</div>
        </li>
      </ul>
    </div>
    <div v-if="showModal" class="modal-overlay">
      <div class="modal-content">
        <font-awesome-icon @click="closeModal" size="2x" :icon="['fas', 'xmark']"
          :style="{ color: 'white', cursor: 'pointer' }" />
        <h3>Détails du client</h3>
        <ClientForm v-if="selectedClient" :client="selectedClient" @submit="handleSubmit" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ClientForm from '../components/ClientForm.vue';

const showModal = ref(false);
const selectedClient = ref(null);
const clients = ref([]);

const fetchClients = async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/clients');
    clients.value = response.data.member;
  } catch (error) {
    console.error('Error fetching clients:', error);
  }
};

onMounted(() => {
  fetchClients();
});

const openModal = (client) => {
  selectedClient.value = client; 
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedClient.value = null; 
};

const handleSubmit = (formData) => {

  console.log('Form submitted:', formData);
  closeModal(); 
  fetchClients()
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

h2 small {
  font-size: 0.5em;
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

.responsive-table .table-header {
  background-color: #95A5A6;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 0.03em;
}

.responsive-table .table-row {
  background-color: var(--dark);
  color: #ffffff;
  box-shadow: 0px 0px 9px 0px rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

.table-row [data-label="clientType"] {
  color: #8680F9;
}

.responsive-table .col-1 {
  flex-basis: 10%;
}

.responsive-table .col-2 {
  flex-basis: 40%;
}

.responsive-table .col-3 {
  flex-basis: 25%;
}

.responsive-table .col[data-label="Status"] {
  color: #8680F9;
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
  /* height: 100%; */
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