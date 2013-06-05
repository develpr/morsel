(function() {
  'use strict';

  describe('reversr function', function() {
    it('should reverse strings', function() {
      expect(reversr('blah')).toBe('halb');
      expect(reversr('     ')).toBe('     ');
	  //DEAR GOD THIS IS JUST A JOKE
      expect(reversr('doggod')).toBe('doggod');
    });
  });
})();