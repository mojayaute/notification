import React from 'react';
import { Link, useForm, usePage } from '@inertiajs/react';
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';

const Create = () => {
  const { categories } = usePage().props;
  
  const { data, setData, errors, post, processing } = useForm({
    category_id: '',
    message: '',
  });

  function handleSubmit(e) {
    e.preventDefault();
    post(route('category.store'));
  }

  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">
      Submission form
      </h1>
      <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
        <form onSubmit={handleSubmit}>
          <div className="flex flex-wrap p-8 -mb-8 -mr-6">

          <SelectInput
           className="w-full pb-8 pr-6 lg:w-1/2"
           label="Category"
            onChange={e => setData('category_id', e.target.value)}
            name="category_id"
            errors={errors.category_id}
            value={data.category_id}
          >
            <option value="">Select Category</option>
            {categories.map(op => (
              <option key={op.id} value={op.id}>{op.name}</option>
            ))}
          </SelectInput>
            <TextInput
              className="w-full pb-8 pr-6 lg:w-1/2"
              label="Message"
              name="message"
              type="text"
              errors={errors.message}
              value={data.message}
              onChange={e => setData('message', e.target.value)}
            />
            
          </div>
          <div className="flex items-center justify-end px-8 py-4 bg-gray-100 border-t border-gray-200">
            <LoadingButton
              loading={processing}
              type="submit"
              className="btn-indigo"
            >
              Submit
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

Create.layout = page => <Layout title="Notification Test" children={page} />;

export default Create;
