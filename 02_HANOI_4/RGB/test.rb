class Disc
	attr_accessor :size
	
	def initialize(size = 1)
		@size = size
	end
end

class Stick
	attr_accessor :discs
	
	def initialize(discs = [])
		@discs = discs
	end
	
	def get_top_disc_size()
		disc_size = 0;
		
		top_disc = discs.last;
		
		if false == top_disc.nil?
			disc_size = top_disc.size
		end
		
		return disc_size;
	end
	
	def is_can_push_disc(disc)
		if true == disc.nil?
			return false
		end
		
		if Disc != disc.class
			return false
		end
		
		if 0 == get_top_disc_size()
			return true
		end
		
		return disc.size() <= get_top_disc_size()
	end
	
	def push_disc(disc)
		if is_can_push_disc(disc) == true
			discs << disc
		end
	end
	
	def prints_discs_size()
		discs.each do |disc|
			print "#{disc.size()} "
		end
	end
	
	private :discs;
end

class TestInformation
	attr_accessor :disc_count, :sticks
	
	def initialize(disc_count = 0, sticks = [])
		@disc_count = disc_count
		@sticks = sticks
	end
	
	def add_stick_info(disc_size_array)
	
		created_disc_array = []
		disc_size_array.each_with_index do |disc_size, index|
			if index != 0
				created_disc_array << Disc.new(disc_size)
			end
		end
		
		sticks << Stick.new(created_disc_array)
	end
	
	def display_test_info()
		puts "All Disc Count : #{disc_count}"
		
		sticks.each_with_index do |stick, index|
			print " - Stick Info : "
			print "#{index} |"
			stick.prints_discs_size()
			puts ""
		end
	end
	
	private :sticks
end


print "please enter test case count: "
test_case_count_str = gets

test_case_count_str = test_case_count_str.chomp

test_case_count = test_case_count_str.to_i();

if test_case_count < 0
	test_case_count = 0;
else
	if test_case_count > 50
		test_case_count = 50;
	end
end

test_case_array = []

for i in 0..test_case_count-1 do
	curr_test_info = TestInformation.new
	test_case_array << curr_test_info
	
	curr_test_info.disc_count = gets.to_i()
	
	for stick_i in 0..3 do
		stick_info = gets
		
		stick_array = stick_info.split(" ")
		curr_test_info.add_stick_info(stick_array)
	end
	
	curr_test_info.display_test_info();
end


puts "The test case count is #{test_case_count}" 