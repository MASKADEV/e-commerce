import React, { useEffect } from 'react'
import { Link } from 'react-router-dom';
import { ProductsProps } from '../../../types'

const ProductCard:React.FC<ProductsProps> = ({title, id,description, image_url, price, categorie}) => {


  return (
        <div className="relative flex flex-col text-white p-4 md:ml-3 items-center overflow-hidden">
            <div className='h-[16.5rem] w-[16.5rem] overflow-hidden'>
                <img className='rounded-md' src={image_url} alt="products" />
            </div>
            <div className='flex flex-row justify-between items-center w-full'>
                <div className='mt-1 flex flex-col items-start justify-start'>
                    <h1 className='md:text-xl text-sm'>{title}</h1>
                    <p className='text-sm text-gray'>{categorie}</p>
                </div>
                <div>
                    <p className='md:text-xl font-medium'>{price} Eth</p>
                </div>
            </div>
            <div className='w-full mt-1'>
                <Link to={`/product_detail/${id}`}><div className='w-full bg-main-color py-3 text-center rounded-md hover:bg-white hover:text-main-color'>View Details</div>
                </Link>
            </div>
        </div>
  )

}

export default ProductCard