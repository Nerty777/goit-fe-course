import axios from 'axios';

const getAllItems = BASE_URL => {
  return axios.get(BASE_URL).then(response => {
    return response.data;
  });
};

const getItemById = (BASE_URL, id) => {
  return axios.get(`${BASE_URL}/${id}`).then(response => {
    return response.data;
  });
};

const deleteItem = (BASE_URL, id) => {
  return axios.delete(`${BASE_URL}/${id}`).then(response => {
    return response.status === 200;
  });
};

const addItem = (BASE_URL, item) => {
  return axios.post(BASE_URL, item).then(response => {
    return response.data;
  });
};

export { getAllItems, getItemById, deleteItem, addItem };
