import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import Layout from '@/Shared/Layout';
import SearchFilter from '@/Shared/SearchFilter';
import Pagination from '@/Shared/Pagination';

const Index = () => {
  const { logs } = usePage().props;
  const {
    data,
    meta: { links }
  } = logs;
  
  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">Log History</h1>
      <div className="flex items-center justify-between mb-6">
        <SearchFilter />
      </div>
      <div className="overflow-x-auto bg-white rounded shadow">
        <table className="w-full whitespace-nowrap">
          <thead>
            <tr className="font-bold text-left">
            <th className="px-6 pt-5 pb-4">Message</th>
              <th className="px-6 pt-5 pb-4">User name</th>
              <th className="px-6 pt-5 pb-4">Category</th>
              <th className="px-6 pt-5 pb-4" >
                Channel
              </th>
              <th className="px-6 pt-5 pb-4" colSpan="2">
                Date
              </th>
            </tr>
          </thead>
          <tbody>
            {data.logs.map(({ id, message, user, category, channel, created_at }) => {
              return (
                <tr
                  key={id}
                  className="hover:bg-gray-100 focus-within:bg-gray-100"
                >
                  <td className="border-t">
                  <div className='flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none'>
                      {message}
                      </div>
                  </td>
                  <td className="border-t">
                      <div className='flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none'>
                        {user.name}
                      </div>
                  </td>
                  <td className="border-t">
                    <div className='flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none'>
                    {category.name}
                    </div>
                  </td>
                  <td className="border-t">
                    <div className='flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none'>
                    {channel.name}
                    </div>
                  </td>

                  <td className="border-t">
                    <div className='flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none'>
                    { created_at }
                    </div>
                  </td>
                </tr>
              );
            })}
            {data.length === 0 && (
              <tr>
                <td className="px-6 py-4 border-t" colSpan="4">
                  No records found.
                </td>
              </tr>
            )}
          </tbody>
        </table>
      </div>
      <Pagination links={links} />
    </div>
  );
};

Index.layout = page => <Layout title="Logs" children={page} />;

export default Index;
