import { API } from "../_api";

const authHeader = () => {
  return {
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`,
    },
  };
};

export const getGenres = async () => {
  const { data } = await API.get("/genres");
  return data.data;
};

export const showGenre = async (id) => {
  try {
    const { data } = await API.get(`/genres/${id}`);
    return data.data;
  } catch (error) {
    console.log(error);
    throw error;
  }
};

export const createGenre = async (data) => {
  try {
    const response = await API.post("/genres", data, authHeader());
    return response.data;
  } catch (error) {
    console.log(error);
    throw error;
  }
};

export const updateGenre = async (id, data) => {
  try {
    const response = await API.post(`/genres/${id}`, data, authHeader());
    return response.data;
  } catch (error) {
    console.log(error);
    throw error;
  }
};

export const deleteGenre = async (id) => {
  try {
    await API.delete(`/genres/${id}`, authHeader());
  } catch (error) {
    console.log(error);
    throw error;
  }
};