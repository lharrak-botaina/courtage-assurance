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
            @click="updateClient"
            :icon="['fas', 'pen-to-square']"
            :style="{ color: 'yellow', cursor: 'pointer' }"
          />
          <font-awesome-icon
          @click="deleteClient(client.id)"
            :icon="['fas', 'circle-xmark']"
            :style="{ color: '#A1136B', cursor: 'pointer' }"
          />
        </div>
      </div>
      <div class="row">
        <div class="input-group col-half">
          <label for="nom">Nom:</label>
          <input
            type="text"
            v-model="form.nom"
            placeholder="Entrez votre nom"
            required
          />
          <span v-if="errors.nom" class="error">{{ errors.nom }}</span>
        </div>
      </div>
      <div class="row">
        <div class="input-group col-half">
          <label for="prenom">Prénom:</label>
          <input
            type="text"
            v-model="form.prenom"
            placeholder="Entrez votre prénom"
            required
          />
           <span v-if="errors.nom" class="error">{{ errors.prenom }}</span>
        </div>
      </div>
      <div class="row">
        <div class="input-group col-half">
          <label for="dateNaissance">Date de naissance:</label>
          <input type="date" v-model="form.date_naissance" required />
          <span v-if="errors.date_naissance" class="error">{{ errors.date_naissance }}</span>
        </div>
      </div>
      <div class="row">
        <div class="input-group col-half">
          <label for="estPersonne">Est une personne:</label>
          <div class="radio-group">
            <label>
              <input
                type="radio"
                v-model="form.est_personne"
                :value="true"
              /> Oui

            </label>

            <label>
              <input
                type="radio"
                v-model="form.est_personne"
                :value="false"
              /> Non
            </label>

          </div>
          
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, defineEmits, watch, toRefs } from 'vue';
import axios from 'axios';

const props = defineProps({
  client: {
    type: Object,
    default: () => ({ nom: '', prenom: '', date_naissance: '', est_personne: null, id: null }),
  },
});

const emit = defineEmits(['submit']);

const form = ref({
  nom: props.client.nom || '',
  prenom: props.client.prenom || '',
  date_naissance: props.client.date_naissance ? props.client.date_naissance.split('T')[0] : '',
  est_personne: props.client.est_personne,
  id: props.client.id || null 
});

const errors = ref({});

watch(() => props.client, (newClient) => {
  if (newClient) {
    form.value.nom = newClient.nom || '';
    form.value.prenom = newClient.prenom || '';
    form.value.date_naissance = newClient.date_naissance ? newClient.date_naissance.split('T')[0] : '';
    form.value.est_personne = newClient.est_personne;
    form.value.id = newClient.id; 
  }
});

const validateForm = () => {
  errors.value = {}; 
  if (!form.value.nom) {
    errors.value.nom = "Le nom est requis.";
  }
  if (!form.value.prenom) {
    errors.value.prenom = "Le prénom est requis.";
  }
  if (!form.value.date_naissance) {
    errors.value.date_naissance = "La date de naissance est requise.";
  }
  if (form.value.est_personne === null) {
    errors.value.est_personne = "Veuillez indiquer si c'est une personne.";
  }
  return Object.keys(errors.value).length === 0;
};

const updateClient = async () => {
  if (validateForm()) {
    try {
      const clientId = form.value.id; 
      const response = await axios.patch(`http://127.0.0.1:8000/api/clients/${clientId}`, {
        nom: form.value.nom,
        prenom: form.value.prenom,
        date_naissance: form.value.date_naissance,
        est_personne: form.value.est_personne,
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
