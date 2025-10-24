import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import { getAuthors } from "../../../_services/authors";

export default function AuthorsIndex() {
  const [authors, setAuthors] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const authorsData = await getAuthors();
        setAuthors(authorsData);
      } catch (error) {
        console.error("Error fetching authors:", error);
      }
    };
    fetchData();
  }, []);

  return (
    <>
      <div className="flex justify-between items-center mb-4">
        <h1 className="text-2xl font-semibold text-gray-900 dark:text-white">Author Management</h1>
        <Link
          to={"create"}
          className="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800"
        >
          Add New Author
        </Link>
      </div>

      <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" className="px-6 py-3">
                Author ID
              </th>
              <th scope="col" className="px-6 py-3">
                Author Name
              </th>
              {/* Kolom Baru: Photo */}
              <th scope="col" className="px-6 py-3">
                Photo
              </th>
              {/* Kolom Baru: Bio */}
              <th scope="col" className="px-6 py-3">
                Bio
              </th>
              <th scope="col" className="px-6 py-3">
                <span className="sr-only">Actions</span>
              </th>
            </tr>
          </thead>
          <tbody>
            {authors.map((author) => (
              <tr
                key={author.id}
                className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
              >
                <th
                  scope="row"
                  className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                >
                  {author.id}
                </th>
                <td className="px-6 py-4">{author.name}</td>
                {/* Menampilkan Status Photo (seperti di halaman Books) */}
                <td className="px-6 py-4">
                  {author.photo ? "Yes" : "No"}
                </td>
                {/* Menampilkan Bio */}
                <td className="px-6 py-4 truncate max-w-xs">{author.bio}</td>
                <td className="px-6 py-4 text-right">
                  {/* Action Dropdown would go here (Edit/Delete) */}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </>
  );
}