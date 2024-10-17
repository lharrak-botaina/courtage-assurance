<template>
    <div class="form-container">
      <form @submit.prevent="submitForm">
        <div class="form-header">
          <div class="action-icons">
            <font-awesome-icon
              :icon="['fas', 'file-export']"
              :style="{ color: '#00FC80', cursor: 'pointer' }"
            />
            <font-awesome-icon
              @click="updateVoiture"
              :icon="['fas', 'pen-to-square']"
              :style="{ color: 'yellow', cursor: 'pointer' }"
            />
            <font-awesome-icon
              @click="deleteVoiture(voiture.id)"
              :icon="['fas', 'circle-xmark']"
              :style="{ color: '#A1136B', cursor: 'pointer' }"
            />
          </div>
        </div>
        <div class="row">
          <div class="input-group col-half">
            <label for="numero_immatriculation">Plaque d’immatriculation:</label>
            <input
              type="text"
              v-model="form.numero_immatriculation"
              placeholder="Entrez la plaque d’immatriculation"
              required
            />
            <span v-if="errors.numero_immatriculation" class="error">{{ errors.numero_immatriculation }}</span>
          </div>
        </div>
        <div class="row">
          <div class="input-group col-half">
            <label for="date_achat">Date d'achat:</label>
            <input type="date" v-model="form.date_achat" required />
            <span v-if="errors.date_achat" class="error">{{ errors.date_achat }}</span>
          </div>
        </div>
        <div class="row">
          <div class="input-group col-half">
            <label for="vehicleUsage">Usage du véhicule:</label>
            <input type="text" v-model="form.vehicleUsage" required />
            <span v-if="errors.vehicleUsage" class="error">{{ errors.vehicleUsage }}</span>
          </div>
        </div>
        <div class="row">
        <div class="input-group col-half">
          <label for="emplacement">Emplacement:</label>
          <input type="text" v-model="form.emplacement" placeholder="Entrez l'emplacement" required />
          <span v-if="errors.emplacement" class="error">{{ errors.emplacement }}</span>
        </div>
      </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, defineEmits, watch } from 'vue';
  import axios from 'axios';
  
  const props = defineProps({
    voiture: {
      type: Object,
      default: () => ({ numero_immatriculation: '', date_achat: '', vehicleUsage: '', id: null , emplacement: ''}),
    },
  });
  
  const emit = defineEmits(['submit']);
  
  const form = ref({
    numero_immatriculation: props.voiture.numero_immatriculation || '',
   
    date_achat: props.voiture.date_achat ? props.voiture.date_achat.split('T')[0] : '',

    vehicleUsage: props.voiture.vehicleUsage || '',
    emplacement: props.voiture.emplacement || '',
    id: props.voiture.id || null,
  });
  
  const errors = ref({});
  
  watch(() => props.voiture, (newVoiture) => {
    if (newVoiture) {
      form.value.numero_immatriculation = newVoiture.numero_immatriculation || '';
      form.value.date_achat = newVoiture.date_achat || '';
      form.value.vehicleUsage = newVoiture.vehicleUsage || '';
      form.value.emplacement = newVoiture.emplacement || '';
      form.value.id = newVoiture.id;
    }
  });
  
  const validateForm = () => {
    errors.value = {};
    if (!form.value.numero_immatriculation) {
      errors.value.numero_immatriculation = "La plaque d’immatriculation est requise.";
    }
    if (!form.value.date_achat) {
      errors.value.date_achat = "La date d'achat est requise.";
    }
    if (!form.value.vehicleUsage) {
      errors.value.vehicleUsage = "L'usage du véhicule est requis.";
    }
    if (!form.value.emplacement) {
    errors.value.emplacement = "L'emplacement est requis.";
  }
    return Object.keys(errors.value).length === 0;
  };
  
  const updateVoiture = async () => {
  if (validateForm()) {
    try {

    const voitureId = form.value.id; 
      const response = await axios.patch(`http://127.0.0.1:8000/api/voitures/${voitureId}`, {
        numero_immatriculation: form.value.numero_immatriculation,
        date_achat: form.value.date_achat,
        vehicleUsage: form.value.vehicleUsage,
        emplacement: form.value.emplacement, 
      }, {
        headers: {
          'Content-Type': 'application/merge-patch+json'
        }
      });
      console.log('Update successful:', response.data);
      emit('submit', response.data); 
      
     
      fetchClients(); 

    } catch (error) {
      console.error('Error updating client:', error);
    }
  }
};

const fetchVoitures = async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/voitures');
    voitures.value = response.data.member; 
    
  } catch (error) {
    console.error('Error fetching voitures:', error);
  }
};

const deleteVoiture = async (voitureId) => {
  if (confirm("Êtes-vous sûr de vouloir supprimer cette voiture ?")) {
    try {
      console.log(`Deleting voiture with ID: ${voitureId}`);
      const response = await axios.delete(`http://127.0.0.1:8000/api/voitures/${voitureId}`);
      console.log('Delete response:', response.data);
      emit('submit', response.data); 
      fetchVoitures(); 
    } catch (error) {
      console.error('Error deleting voiture:', error);
    }
  }
};

  </script>
  
  <style scoped>
 
  .form-container {
    background-color: #403378;
    padding: 20px;
    border-radius: 8px;
  }
  
  
  .form-header {
    display: flex;
    justify-content: end;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .form-header h2 {
    color: #fff;
    font-size: 1.5rem;
    margin: 0;
  }
  
  .form-header p {
    color: #ccc;
    font-size: 0.9rem;
  }
  
  .action-icons {
    display: flex;
    gap: 15px;
  }
  
  .action-icons i {
    color: #fff;
    font-size: 1.2rem;
    cursor: pointer;
    transition: color 0.2s;
  }
  
  .action-icons i:hover {
    color: #f0a500;
  }
  
  label {
    color: #fff;
    font-weight: bold;
    margin-bottom: 5px;
  }
  
  input,
  select {
    width: 100%;
    padding: 0.75em;
    background-color: #403378;
    color: #fff;
    border: 1px solid #fff;
    border-radius: 5px;
  }
  
  .radio-group {
    display: flex;
    gap: 20px;
    margin-top: 10px;
  }
  
  .radio-group label {
    color: #fff;
    display: flex;
    align-items: center;
    gap: 5px;
  }
  
  .submit-button {
    background-color: white;
    color: 403378;
    border: none;
    border-radius: 10px;
    padding: 1em;
    cursor: pointer;
    width: 90%;
    font-weight: bold;
  }
  
  .row {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 10px;
  }
  
  .col-half {
    padding-right: 10px;
    width: 100%;
  }
  
  @media only screen and (max-width: 540px) {
    .col-half {
      width: 100%;
      padding-right: 0;
    }
  }
  </style>