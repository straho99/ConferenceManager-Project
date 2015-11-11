namespace ConferenceManager.Data
{
    using System.Data.Entity;
    using System.Data.Entity.ModelConfiguration.Conventions;

    using ConferenceManager.Models;

    public class ConferenceManagerContext : DbContext
    {
        public ConferenceManagerContext()
            : base("name=ConferenceManagerContext")
        {
        }

        public virtual IDbSet<User> Users { get; set; }

        public virtual IDbSet<Role> Roles { get; set; }

        public virtual IDbSet<Venue> Venues { get; set; }

        public virtual IDbSet<Hall> Halls { get; set; }

        public virtual IDbSet<Conference> Conferences { get; set; }

        public virtual IDbSet<Lecture> Lectures { get; set; }

        public virtual IDbSet<Break> Breaks { get; set; }

        public virtual IDbSet<Notification> Notifications { get; set; }

        public virtual IDbSet<Message> Messages { get; set; }

        public virtual IDbSet<VenueReservationRequest> VenueReservationRequests { get; set; }

        public IDbSet<SpeakerInvitation> SpeakerInvitations { get; set; }

        protected override void OnModelCreating(DbModelBuilder modelBuilder)
        {
            base.OnModelCreating(modelBuilder);

            modelBuilder.Conventions.Remove<ManyToManyCascadeDeleteConvention>();

            modelBuilder.Entity<User>()
                .HasOptional(u => u.Role)
                .WithMany(r => r.Users)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<User>()
                .HasMany(u => u.MyConferences)
                .WithRequired(c => c.Owner)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<User>()
                .HasMany(u => u.AttendingConferences)
                .WithMany(c => c.Participants)
                .Map(m =>
                {
                    m.MapLeftKey("ConferenceId");
                    m.MapRightKey("ParticipantId");
                    m.ToTable("ConferencesParticipants");
                });

            modelBuilder.Entity<User>()
                .HasMany(u => u.AttendingLectures)
                .WithMany(l => l.Participants)
                .Map(m =>
                {
                    m.MapLeftKey("LectureId");
                    m.MapRightKey("ParticipantId");
                    m.ToTable("LecturesParticipants");
                });

            modelBuilder.Entity<User>()
                .HasMany(u => u.MyLectures)
                .WithRequired(c => c.Speaker)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<User>()
                .HasMany(u => u.MySpeakerInvitations)
                .WithRequired(c => c.Speaker)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<User>()
                .HasMany(u => u.MyVenues)
                .WithRequired(c => c.Owner)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<Venue>()
                .HasMany(v => v.Halls)
                .WithRequired(h => h.Venue)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<Venue>()
                .HasMany(v => v.Conferences)
                .WithRequired(c => c.Venue)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<Venue>()
                .HasMany(v => v.ReservationRequests)
                .WithRequired(c => c.Venue)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<Lecture>()
                .HasMany(l => l.SpeakerInvitations)
                .WithRequired(s => s.Lecture)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<Lecture>()
                .HasMany(l => l.Breaks)
                .WithRequired(b => b.Lecture)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<User>()
                .HasMany(u => u.Notifications)
                .WithRequired(n => n.Recipient)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<User>()
                .HasMany(u => u.SentMessages)
                .WithRequired(n => n.Sender)
                .WillCascadeOnDelete(false);

            modelBuilder.Entity<User>()
                .HasMany(u => u.RecievedMessages)
                .WithRequired(n => n.Recipient)
                .WillCascadeOnDelete(false);
        }
    }
}