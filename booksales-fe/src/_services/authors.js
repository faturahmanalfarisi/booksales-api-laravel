import { API } from "../_api";

const authHeader = () => {
  return {
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`,
    },
  };
};

export const getAuthors = async () => {
  const { data } = await API.get("/authors");
  return data.data;
};

export const showAuthor = async (id) => {
  try {
    const { data } = await API.get(`/authors/${id}`);
    return data.data;
  } catch (error) {
    console.log(error);
    throw error;
  }
};

export const createAuthor = async (data) => {
  try {
    const response = await API.post("/authors", data, authHeader());
    return response.data;
  } catch (error) {
    console.log(error);
    throw error;
  }
};

export const updateAuthor = async (id, data) => {
  try {
    const response = await API.post(`/authors/${id}`, data, authHeader());
    return response.data;
  } catch (error) {
    console.log(error);
    throw error;
  }
};

export const deleteAuthor = async (id) => {
  try {
    await API.delete(`/authors/${id}`, authHeader());
  } catch (error) {
    console.log(error);
    throw error;
  }
};