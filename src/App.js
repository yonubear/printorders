import React, { useState, useRef } from 'react';
import { Card } from '@/components/ui/card';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import {
  Printer,
  FileText,
  Search,
  Package,
  Camera,
  Image,
  MessageSquare,
  X
} from 'lucide-react';

const App = () => {
  const [activeTab, setActiveTab] = useState('orders');
  const [formData, setFormData] = useState({
    customerName: '',
    email: '',
    phone: '',
    width: '',
    length: '',
    quantity: 1,
    specialInstructions: ''
  });

  // ... Rest of the code remains the same ...

  return (
    <div className="min-h-screen bg-gray-50 p-4">
      <div className="max-w-7xl mx-auto">
        <div className="mb-6">
          <h1 className="text-2xl font-bold text-gray-900">Print Orders</h1>
          <p className="text-gray-600">Manage print orders and materials</p>
        </div>

        <Card>
          <Tabs value={activeTab} onValueChange={setActiveTab}>
            <TabsList className="border-b">
              <TabsTrigger value="orders" className="flex items-center gap-2">
                <FileText size={18} />
                Orders
              </TabsTrigger>
              <TabsTrigger value="new-order" className="flex items-center gap-2">
                <Printer size={18} />
                New Order
              </TabsTrigger>
              <TabsTrigger value="track" className="flex items-center gap-2">
                <Search size={18} />
                Track Order
              </TabsTrigger>
              <TabsTrigger value="materials" className="flex items-center gap-2">
                <Package size={18} />
                Materials
              </TabsTrigger>
            </TabsList>

            <TabsContent value="new-order" className="p-6">
              <form onSubmit={handleSubmit} className="space-y-6">
                <Card>
                  <div className="p-4">
                    <h2 className="text-lg font-semibold mb-4">Order Details</h2>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <Label>Customer Name</Label>
                        <Input
                          value={formData.customerName}
                          onChange={(e) => setFormData({ ...formData, customerName: e.target.value })}
                          required
                        />
                      </div>
                      <div>
                        <Label>Email</Label>
                        <Input
                          type="email"
                          value={formData.email}
                          onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                          required
                        />
                      </div>
                      <div>
                        <Label>Phone</Label>
                        <Input
                          type="tel"
                          value={formData.phone}
                          onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                          required
                        />
                      </div>
                      <div>
                        <Label>Width (inches)</Label>
                        <Input
                          type="number"
                          step="0.1"
                          value={formData.width}
                          onChange={(e) => setFormData({ ...formData, width: e.target.value })}
                          required
                        />
                      </div>
                      <div>
                        <Label>Length (inches)</Label>
                        <Input
                          type="number"
                          step="0.1"
                          value={formData.length}
                          onChange={(e) => setFormData({ ...formData, length: e.target.value })}
                          required
                        />
                      </div>
                      <div>
                        <Label>Quantity</Label>
                        <Input
                          type="number"
                          min="1"
                          value={formData.quantity}
                          onChange={(e) => setFormData({ ...formData, quantity: parseInt(e.target.value) })}
                          required
                        />
                      </div>
                    </div>

                    <div className="mt-4">
                      <Label>Special Instructions</Label>
                      <Textarea
                        value={formData.specialInstructions}
                        onChange={(e) => setFormData({ ...formData, specialInstructions: e.target.value })}
                        rows={3}
                      />
                    </div>
                  </div>
                </Card>

                {/* Photo Section */}
                <Card className="mt-6">
                  <div className="p-4">
                    <h2 className="text-lg font-semibold mb-4">Order Photos</h2>

                    {/* Category Selection */}
                    <div className="flex flex-wrap gap-2 mb-4">
                      {Object.entries(photoCategories).map(([key, category]) => (
                        <button
                          key={key}
                          onClick={() => setActiveCategory(key)}
                          className={`flex items-center space-x-2 px-4 py-2 rounded-lg transition-all
                            ${activeCategory === key
                              ? category.color + ' text-white'
                              : 'bg-gray-100 hover:bg-gray-200'
                            }`}
                        >
                          {category.icon}
                          <span>{category.label}</span>
                        </button>
                      ))}
                    </div>

                    {/* Active Category Description */}
                    <CategoryDescription category={photoCategories[activeCategory]} />

                    {/* Camera Interface */}
                    {showCamera ? (
                      <div className="relative rounded-lg overflow-hidden bg-black mt-4">
                        <video
                          ref={videoRef}
                          autoPlay
                          playsInline
                          className="w-full"
                        />
                        <div className="absolute bottom-4 left-0 right-0 flex justify-center space-x-4">
                          <Button
                            onClick={capturePhoto}
                            className={photoCategories[activeCategory].color}
                          >
                            <Camera size={24} />
                          </Button>
                          <Button
                            onClick={stopCamera}
                            variant="destructive"
                          >
                            Close Camera
                          </Button>
                        </div>
                      </div>
                    ) : (
                      <Button onClick={startCamera} className={`${photoCategories[activeCategory].color} mt-4`}>
                        <Camera size={20} className="mr-2" />
                        Take {photoCategories[activeCategory].label}
                      </Button>
                    )}

                    {/* Photo Gallery */}
                    {Object.entries(photos).map(([category, categoryPhotos]) => (
                      categoryPhotos.length > 0 && (
                        <div key={category} className="mt-6">
                          <div className="flex items-center justify-between mb-3">
                            <div className="flex items-center gap-2">
                              {photoCategories[category].icon}
                              <h3 className="font-semibold">{photoCategories[category].label}</h3>
                              <span className="text-sm text-gray-500">
                                ({categoryPhotos.length})
                              </span>
                            </div>
                            {photoCategories[category].required && (
                              <Badge variant="secondary">Required</Badge>
                            )}
                          </div>

                          <div className="grid grid-cols-2 md:grid-cols-3 gap-4">
                            {categoryPhotos.map((photo, index) => (
                              <div key={index} className="relative group aspect-square">
                                <img
                                  src={photo.url}
                                  alt={`$${category} photo$$ {index + 1}`}
                                  className="w-full h-full object-cover rounded-lg"
                                />
                                <div className="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all rounded-lg">
                                  <Button
                                    onClick={() => deletePhoto(category, index)}
                                    variant="destructive"
                                    size="icon"
                                    className="absolute top-2 right-2 opacity-0 group-hover:opacity-100"
                                  >
                                    <X size={16} />
                                  </Button>
                                </div>
                                <div className="absolute bottom-2 left-2 right-2 text-xs text-white bg-black bg-opacity-50 px-2 py-1 rounded opacity-0 group-hover:opacity-100">
                                  {new Date(photo.timestamp).toLocaleString()}
                                </div>
                              </div>
                            ))}
                          </div>
                        </div>
                      )
                    ))}
                  </div>
                </Card>

                <div className="flex justify-end gap-4">
                  <Button type="button" variant="outline">
                    Reset
                  </Button>
                  <Button type="submit">Submit Order</Button>
                </div>
              </form>
            </TabsContent>

            {/* ... Rest of the code remains the same ... */}
          </Tabs>
        </Card>
      </div>
    </div>
  );
};

export default App;
