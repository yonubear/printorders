import React from 'react';
import { Camera, FileText, MessageSquare, X } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card } from '@/components/ui/card';

const photoCategories = {
  proof: {
    label: 'Proof Photos',
    description: 'Final printed materials for approval',
    icon: <Camera size={20} />,
    color: 'bg-blue-500',
    maxPhotos: 5,
    required: true,
    placeholder: 'Take clear photos of the final print for client approval'
  },
  reference: {
    label: 'Reference Photos',
    description: 'Reference materials and examples',
    icon: <FileText size={20} />,
    color: 'bg-green-500',
    maxPhotos: 10,
    required: false,
    placeholder: 'Upload reference images or examples'
  },
  notes: {
    label: 'Notes & Comments',
    description: 'Client communication and notes',
    icon: <MessageSquare size={20} />,
    color: 'bg-purple-500',
    maxPhotos: 10,
    required: false,
    placeholder: 'Photos for client discussion'
  }
};

const PhotoCategories = ({ 
  activeCategory, 
  setActiveCategory, 
  photos, 
  deletePhoto, 
  showCamera,
  startCamera,
  stopCamera,
  videoRef,
  capturePhoto
}) => {
  const CategoryDescription = ({ category }) => (
    <div className="space-y-2 mt-2">
      <p className="text-sm text-gray-600">{category.description}</p>
      <div className="flex items-center gap-2 text-xs text-gray-500">
        <span>Max photos: {category.maxPhotos}</span>
        {category.required && (
          <span className="text-red-500">Required</span>
        )}
      </div>
      <p className="text-xs text-gray-400 italic">{category.placeholder}</p>
    </div>
  );

  return (
    <Card className="mt-6">
      <div className="p-4">
        <h2 className="text-lg font-semibold mb-4">Order Photos</h2>
        
        {/* Category Selection */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-2 mb-4">
          {Object.entries(photoCategories).map(([key, category]) => (
            <button
              key={key}
              onClick={() => setActiveCategory(key)}
              className={`flex items-center gap-2 p-3 rounded-lg transition-all
                ${activeCategory === key 
                  ? category.color + ' text-white' 
                  : 'bg-gray-100 hover:bg-gray-200'}`}
            >
              {category.icon}
              <span>{category.label}</span>
              {category.required && (
                <span className="text-xs">
                  {activeCategory === key ? '(Required)' : '*'}
                </span>
              )}
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
          <Button 
            onClick={startCamera}
            className={`${photoCategories[activeCategory].color} mt-4`}
          >
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
                    ({categoryPhotos.length}/{photoCategories[category].maxPhotos})
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
                      alt={`${category} photo ${index + 1}`}
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
  );
};

export default PhotoCategories;
