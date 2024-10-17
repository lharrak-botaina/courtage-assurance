import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    clients: [],
    quotes: [],
    vehicles: [],
  },
  mutations: {
    ADD_CLIENT(state, client) {
      state.clients.push(client);
    },
    ADD_QUOTE(state, quote) {
      state.quotes.push(quote);
    },
    ADD_VEHICLE(state, vehicle) {
      state.vehicles.push(vehicle);
    },
  },
  actions: {
    addClient({ commit }, client) {
      commit('ADD_CLIENT', client);
    },
    addQuote({ commit }, quote) {
      commit('ADD_QUOTE', quote);
    },
    addVehicle({ commit }, vehicle) {
      commit('ADD_VEHICLE', vehicle);
    },
  },
});
