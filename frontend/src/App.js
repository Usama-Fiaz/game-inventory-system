import React, { useEffect } from 'react';
import { Provider } from 'react-redux';
import { store } from './store/store';
import { useAppDispatch } from './hooks/redux';
import { fetchItems } from './store/slices/itemsSlice';
import ItemForm from './components/ItemForm';
import ItemList from './components/ItemList';

function AppContent() {
  const dispatch = useAppDispatch();

  useEffect(() => {
    dispatch(fetchItems());
  }, [dispatch]);

  return (
    <div className="min-h-screen bg-gray-100">
      <div className="container mx-auto px-4 py-8">
        <header className="mb-8">
          <h1 className="text-3xl font-bold text-gray-900">Game Inventory Manager</h1>
        </header>
        
        <main>
          <ItemForm />
          <ItemList />
        </main>
      </div>
    </div>
  );
}

function App() {
  return (
    <Provider store={store}>
      <AppContent />
    </Provider>
  );
}

export default App;
