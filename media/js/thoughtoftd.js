/**
 * @package     Joomla.Site
 * @subpackage  mod_thoughtoftd
 * @copyright   Copyright (C) 2005 - 2024 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const thoughtTexts = document.querySelectorAll('.thought-text-collapsible');
        
        thoughtTexts.forEach(function(element) {
            const collapsedHeight = parseInt(element.dataset.collapsedHeight) || 120;
            
            // Check if content exceeds collapsed height
            if (element.scrollHeight > collapsedHeight) {
                // Create wrapper
                const wrapper = document.createElement('div');
                wrapper.className = 'thought-text-wrapper';
                element.parentNode.insertBefore(wrapper, element);
                
                // Create collapsible content
                const collapseDiv = document.createElement('div');
                collapseDiv.className = 'collapse';
                collapseDiv.id = 'thoughtCollapse-' + Math.random().toString(36).substr(2, 9);
                collapseDiv.style.maxHeight = collapsedHeight + 'px';
                collapseDiv.style.overflow = 'hidden';
                
                // Move element into collapse div
                wrapper.appendChild(collapseDiv);
                collapseDiv.appendChild(element);
                
                // Create toggle button
                const toggleBtn = document.createElement('a');
                toggleBtn.className = 'btn btn-link btn-sm thought-toggle';
                toggleBtn.href = '#';
                toggleBtn.setAttribute('data-bs-toggle', 'collapse');
                toggleBtn.setAttribute('data-bs-target', '#' + collapseDiv.id);
                toggleBtn.setAttribute('aria-expanded', 'false');
                toggleBtn.setAttribute('aria-controls', collapseDiv.id);
                toggleBtn.innerHTML = element.dataset.moreText || 'Read more';
                
                wrapper.appendChild(toggleBtn);
                
                // Handle collapse events
                collapseDiv.addEventListener('show.bs.collapse', function() {
                    collapseDiv.style.maxHeight = 'none';
                    toggleBtn.innerHTML = element.dataset.lessText || 'Close';
                });
                
                collapseDiv.addEventListener('hide.bs.collapse', function() {
                    collapseDiv.style.maxHeight = collapsedHeight + 'px';
                    toggleBtn.innerHTML = element.dataset.moreText || 'Read more';
                });
            }
        });
    });
})();

