import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { createAuthor } from "../../../_services/authors";

export default function AuthorCreate() {
  const [formData, setFormData] = useState({
    name: "",
    bio: "",
    photo: null,
  });

  const navigate = useNavigate();

  const handleChange = (e) => {
    const { name, value, files } = e.target;

    if (name === "photo") {
      setFormData({
        ...formData,
        photo: files[0],
      });
    } else {
      setFormData({
        ...formData,
        [name]: value,
      });
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const payload = new FormData();
      // Tambahkan field teks
      payload.append('name', formData.name);
      payload.append('bio', formData.bio);

      // Tambahkan file photo
      if (formData.photo) {
        payload.append('photo', formData.photo);
      }

      await createAuthor(payload);
      navigate("/admin/authors");
    } catch (error) {
      console.log(error);
      alert("Error creating author");
    }
  };

  return (
    <>
      <section className="bg-white dark:bg-gray-900">
        <div className="max-w-2xl px-4 py-8 mx-auto lg:py-16">
          <h2 className="mb-4 text-xl font-bold text-gray-900 dark:text-white">
            Create New Author
          </h2>
          <form onSubmit={handleSubmit}>
            <div className="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
              <div className="sm:col-span-2">
                <label
                  for="name"
                  className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >
                  Author Name
                </label>
                <input
                  type="text"
                  name="name"
                  id="name"
                  value={formData.name}
                  onChange={handleChange}
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                  placeholder="Author Name"
                  required
                />
              </div>

              <div className="sm:col-span-2">
                <label
                  for="bio"
                  className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >
                  Biography (Bio)
                </label>
                <textarea
                  id="bio"
                  name="bio"
                  rows="4"
                  value={formData.bio}
                  onChange={handleChange}
                  className="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                  placeholder="Write a short biography for the author..."
                  required
                ></textarea>
              </div>

              <div className="sm:col-span-2">
                <label
                  for="photo"
                  className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >
                  Author Photo
                </label>
                <input
                  type="file"
                  name="photo"
                  id="photo"
                  accept="image/*"
                  onChange={handleChange}
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full cursor-pointer dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                  required
                />
              </div>
            </div>
            <div className="flex items-center space-x-4">
              <button
                type="submit"
                className="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800"
              >
                Create Author
              </button>
            </div>
          </form>
        </div>
      </section>
    </>
  );
}