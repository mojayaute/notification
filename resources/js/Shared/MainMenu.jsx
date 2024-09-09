import React from 'react';
import MainMenuItem from '@/Shared/MainMenuItem';

export default ({ className }) => {
  return (
    <div className={className}>
      <MainMenuItem text="Users" link="users" icon="users" />
      <MainMenuItem text="Log History" link="log" icon="office" />
      <MainMenuItem text="Category" link="category" icon="office" />
    </div>
  );
};
