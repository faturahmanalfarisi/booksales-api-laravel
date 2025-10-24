import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import { getGenres } from "../../../_services/genres";

export default function GenresIndex() {
  const [genres, setGenres] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const genresData = await getGenres();
        setGenres(genresData);
      } catch (error) {
        console.error("Error fetching genres:", error);
      }
    };
    fetchData();
  }, []);

  return (
    <>
      <div className="flex justify-between items-center mb-4">
        <h1 className="text-2xl font-semibold text-gray-900 dark:text-white">Genre Management</h1>
        <Link
          to={"create"}
          className="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800"
        >
          Add New Genre
        </Link>
      </div>

      <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" className="px-6 py-3">
                Genre ID
              </th>
              <th scope="col" className="px-6 py-3">
                Genre Name
              </th>
              <th scope="col" className="px-6 py-3">
                <span className="sr-only">Actions</span>
              </th>
            </tr>
          </thead>
          <tbody>
            {genres.map((genre) => (
              <tr
                key={genre.id}
                className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
              >
                <th
                  scope="row"
                  className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                >
                  {genre.id}
                </th>
                <td className="px-6 py-4">{genre.name}</td>
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