import { createPinia, setActivePinia } from "pinia";
import piniaPluginPersistedState from 'pinia-plugin-persistedstate'

const pinia = createPinia();
setActivePinia(pinia)
pinia.use(piniaPluginPersistedState)
export default pinia;
