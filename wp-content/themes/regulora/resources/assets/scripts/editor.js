wp.domReady(() => {
  wp.blocks.registerBlockStyle('core/group', [
    {
      name: 'rounded',
      label: 'Round Corners',
    },
  ]);

  wp.blocks.registerBlockStyle('core/pullquote', [
    {
      name: 'with-lines',
      label: 'With Lines',
    },
  ]);
  
  wp.blocks.registerBlockStyle('core/buttons', [
    {
      name: 'tabs',
      label: 'Tabs',
    },
  ]);

  wp.blocks.registerBlockStyle('core/button', [
    {
      name: 'simple-link',
      label: 'Simple Link',
    },
    {
      name: 'short',
      label: 'Short',
    },
    {
      name: 'medium',
      label: 'Medium',
    },
    {
      name: 'wide',
      label: 'Wide',
    },
  ]);

  wp.blocks.registerBlockStyle('core/spacer', [
    {
      name: 'spacer-75',
      label: 'Spacer-75',
    },
    {
      name: 'spacer-110',
      label: 'Spacer-110',
    },
    {
      name: 'spacer-120',
      label: 'Spacer-120',
    },
  ]);

  wp.blocks.registerBlockStyle('core/paragraph', [
    {
      name: 'stroke-style',
      label: 'Stroked',
    },
    // {
    //   name: 'narrow',
    //   label: 'Narrow',
    // },
    // {
    //   name: 'border-bottom',
    //   label: 'Border Bottom',
    // },
  ]);

  wp.blocks.registerBlockStyle('core/separator', [
    {
      name: 'gray-separator',
      label: 'Gray Line',
    },
  ]);

  wp.blocks.registerBlockStyle('core/cover', [
    {
      name: 'full-height-content',
      label: 'Full Height Content',
    },
  ]);

  wp.blocks.registerBlockStyle('core/image', [
    {
      name: 'absolute-to-bottom',
      label: 'Overlay to top',
    },
    {
      name: 'caption-right',
      label: 'Right Caption',
    },
    // {
    //   name: 'icon-with-text',
    //   label: 'Icon With Text',
    // },
    // {
    //   name: 'icon-with-text wide',
    //   label: 'Icon With Text Wide',
    // },
    {
      name: 'bottom-label',
      label: 'Bottom Label',
    },
  ]);
  
  wp.blocks.registerBlockStyle('core/list', [
    {
      name: 'with-icon',
      label: 'With Icon',
    },
  ]);
  
  wp.blocks.registerBlockStyle('core/media-text', [
    {
      name: 'white-text-bg',
      label: 'With White BG',
    },
  ]);
  
  wp.blocks.registerBlockStyle('core/heading', [
    {
      name: 'with-rounded-bg',
      label: 'With Pill BG',
    },
  ]);
  
  wp.blocks.registerBlockStyle('core/columns', [
    {
      name: 'steps',
      label: 'Steps Style',
    },
  ]);
});
